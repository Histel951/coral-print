<?php

namespace App\Services;

use App\Models\FileUpload;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

final class OrderService
{
    public const STATUS_NEW = 1;
    public const STATUS_PROCESSED = 2;

    public function __construct(private CompanyService $companyService)
    {
    }

    /**
     * @param int $id
     * @return false|BinaryFileResponse
     * Скачивание приложенных к заказу файлов, доступных по ссылке в админке в Зака
     */
    public function download(int $id): false|BinaryFileResponse
    {
        try {
            $model = Order::find($id);
            $zip = new ZipArchive();
            $fileName = "attachments_$model->id.zip";

            $zip->open($fileName, ZipArchive::CREATE);

            foreach ($model->attachments as $attachment) {
                $zip->addFile(Storage::disk('public')->path($attachment->path), $attachment->original_name);
            }

            $zip->close();
            $fileUrl = public_path() . '/' . $fileName;

            return response()
                ->download($fileUrl)
                ->deleteFileAfterSend(true);
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @param array $request
     * @return bool
     * Обработка заявки на заказ (из модалки)
     */
    public function send(array $request): bool
    {
        try {
            DB::beginTransaction();

            $model = new Order($request);
            $model->save();

            if (array_key_exists('privileges-photo', $request)) {
                $fileIds = explode(',', $request['privileges-photo']);
                $files = FileUpload::whereIn('id', $fileIds)->get();
                foreach ($files as $file) {
                    $file->fileable_type = Order::class;
                    $file->fileable_id = $model->id;
                    $file->is_temp = false;
                    $file->save();
                }
            }
            DB::commit();

            return true;
        } catch (Exception) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param int $status
     * @return string
     */
    public function getStatusText(int $status): string
    {
        $statuses = [
            self::STATUS_NEW => 'Новый',
            self::STATUS_PROCESSED => 'Обработан',
        ];

        return $statuses[$status] ?? $statuses[self::STATUS_NEW];
    }

    public function createFromApi(array $data): Order
    {
        $companyName = $data['payment']['company_name'] ?? null;

        if (null !== $companyName) {
            $inn = $data['payment']['company_inn'] ?? null;
            $company = $this->companyService->getOrCreate($companyName, $inn);
        }

        $order = Order::create([
            'name' => $data['contacts']['fio'],
            'email' => $data['contacts']['email'],
            'phone' => $data['contacts']['phone'],

            'payment_type_id' => $data['payment']['id'],
            'file_upload_id' => $data['payment']['files'][0]['id'] ?? null,
            'company_id' => $company->id ?? null,

            'delivery_type_id' => $data['delivery']['type'],
            'department_id' => $data['delivery']['city_department'] ?? null,
            'delivery_price' => $data['delivery']['price'] ?? null,

            'delivery_address' => $data['delivery_address'] ?? null,

            'discount' => $data['discount'],
            'price' => $data['order_price'],
            'order_uuid' => Uuid::fromDateTime(Carbon::now()),
        ]);

        foreach ($data['order']['items'] as $item) {
            $formattedProps = $this->formatItem($item);
            OrderItem::create(array_merge(['order_id' => $order->id], $formattedProps));
        }

        return $order;
    }

    public function findOrderByUuid(string $uuid): mixed
    {
        return Order::query()
            ->where('order_uuid', $uuid)
            ->get()
            ->firstOrFail();
    }

    private function formatItem(array $props): array
    {
        $formatted = [];

        foreach ($props as $key => $value) {
            try {
                $formatted[$key] = match ($key) {
                    'name', 'product_count', 'weight' => $value,
                    'design_comment' => strlen($value) > 0 ? $value : null,
                    'product_price', 'design_price', 'item_price', 'total_price' => round($value, 2),
                    'design_services' => json_encode(array_values($value)),
                    'client_designs' => !empty($value) ? json_encode($value) : null,
                };
            } catch (\UnhandledMatchError $e) {
                continue;
            }
        }

        $formatted['props'] = json_encode(array_diff_key($props, $formatted));

        return $formatted;
    }
}
