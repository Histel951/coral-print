<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalculatorConfig>
 */
class CalculatorConfigFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $validators = [
            "rules" => [
                "product_count_types" => [
                    [
                        "validator" => "number"
                    ],
                    [
                        "validator" => "min",
                        "param" => 100
                    ]
                ],
                "width" => [
                    [
                        "validator" => "number"
                    ],
                    [
                        "validator" => "min",
                        "param" => 5,
                        "message" => "Значение не доопустимо маленькое"
                    ],
                    [
                        "validator" => "max",
                        "param" => 1100,
                        "message" => "Значение не доопустимо большое"
                    ]
                ],
                "height" => [
                    [
                        "validator" => "number"
                    ],
                    [
                        "validator" => "min",
                        "param" => 5,
                        "message" => "Значение не доопустимо маленькое"
                    ],
                    [
                        "validator" => "max",
                        "param" => 1100,
                        "message" => "Значение не доопустимо маленькое"
                    ]
                ]
            ],
            "conditions" => [
                [
                    "field" => "print_type",
                    "val" => 14,
                    "rules" => [
                        "width" => [
                            [
                                "validator" => "number"
                            ],
                            [
                                "validator" => "min",
                                "param" => 5,
                                "message" => "Значение не доопустимо маленькое"
                            ],
                            [
                                "validator" => "max",
                                "param" => 1100,
                                "message" => "Значение не доопустимо большое"
                            ]
                        ],
                        "height" => [
                            [
                                "validator" => "number"
                            ],
                            [
                                "validator" => "min",
                                "param" => 5,
                                "message" => "Значение не доопустимо маленькое"
                            ],
                            [
                                "validator" => "max",
                                "param" => 1100,
                                "message" => "Значение не доопустимо большое"
                            ]
                        ]
                    ]
                ],
                [
                    "field" => "print_type",
                    "val" => 15,
                    "rules" => [
                        "width" => [
                            [
                                "validator" => "number"
                            ],
                            [
                                "validator" => "min",
                                "param" => 5,
                                "message" => "Значение не доопустимо маленькое"
                            ],
                            [
                                "validator" => "max",
                                "param" => 300,
                                "message" => "Значение не доопустимо большое"
                            ]
                        ],
                        "height" => [
                            [
                                "validator" => "number"
                            ],
                            [
                                "validator" => "min",
                                "param" => 5,
                                "message" => "Значение не доопустимо маленькое"
                            ],
                            [
                                "validator" => "max",
                                "param" => 430,
                                "message" => "Значение не доопустимо большое"
                            ]
                        ]
                    ]
                ]
            ]

        ];

        return [
            'fields' => ['print_type', 'width_height', 'product_count_types', 'material', 'lam', 'cutting'],
            'validators' => $validators
        ];
    }
}
