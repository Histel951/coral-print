<?php

use App\Models\PivotTooltip;
use App\Models\Tooltip;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tooltip = Tooltip::query()->create([
            'name' => 'Виды нарезки наклеек',
            'type' => 'long',
//            'description' => 'Стандартная подсказка',
            'content' => <<<CONTENT
                <div class="main-content">
        <div class=" flex-container">
          <div class="img item">
            <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g filter="url(#filter0_d_3056_7777)">
                <rect x="6" y="6" width="128" height="128" fill="#F1F2F0"/>
              </g>
              <circle cx="101" cy="38.8589" r="29" fill="url(#paint0_linear_3056_7777)"/>
              <circle opacity="0.3" cx="101" cy="38.8589" r="25" stroke="#00195A" stroke-linejoin="round"/>
              <circle cx="101" cy="100.718" r="29" fill="url(#paint1_linear_3056_7777)"/>
              <circle opacity="0.3" cx="101" cy="100.718" r="25" stroke="#00195A" stroke-linejoin="round"/>
              <circle cx="39" cy="100.718" r="29" fill="url(#paint2_linear_3056_7777)"/>
              <circle opacity="0.3" cx="39" cy="100.718" r="25" stroke="#00195A" stroke-linejoin="round"/>
              <path d="M87.1374 115.711L85.5299 117.318L82.2913 115.709L80.6817 112.47L82.2892 110.863C83.6278 109.524 85.7977 109.524 87.1368 110.863H87.1374C88.476 112.202 88.476 114.372 87.1374 115.711Z" fill="url(#paint3_linear_3056_7777)"/>
              <path d="M74.7932 126.844L67.7777 133.859L67.4242 126.94L70.2476 124.116L74.7932 126.844Z" fill="url(#paint4_linear_3056_7777)"/>
              <path d="M85.5296 117.319L75.8535 126.995L71.4087 126.591L69.7931 123.359L80.6814 112.47L85.5296 117.319Z" fill="url(#paint5_linear_3056_7777)"/>
              <circle cx="39" cy="39" r="29" fill="url(#paint6_linear_3056_7777)"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M56.679 21.4127C52.1568 16.8906 45.9053 14.0918 38.9998 14.0918C35.706 14.0918 32.5649 14.7273 29.6805 15.8884L29.5767 15.9373L29.5768 15.9377C29.5769 15.9377 29.5769 15.9377 29.5769 15.9377C30.7869 15.4733 31.8258 15.7116 32.5713 16.4755L48.1361 34.5212L61.4336 45.3254C62.4485 46.3342 62.6233 47.2947 62.1744 48.4774C63.3429 45.5859 63.9999 42.4027 63.9999 39.0918C63.9999 32.1864 61.2011 25.941 56.679 21.4127Z" fill="#E5EBEF"/>
              <path opacity="0.3" d="M62.1669 48.4965C61.898 49.1993 61.5742 49.8715 61.238 50.5315C57.0215 58.7263 48.5088 64.0917 39.0001 64.0917C25.1954 64.0917 14 52.9025 14 39.0917C14 29.467 19.4999 20.8627 27.8659 16.7072C28.422 16.4261 28.9903 16.1573 29.5769 15.9373" stroke="#00195A" stroke-linejoin="round"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M38.2792 38.8782C29.9805 30.0967 34.5515 18.4553 32.5716 16.4753L61.5744 45.4536C58.0972 42.007 46.5841 47.6535 38.2792 38.8782Z" fill="url(#paint7_linear_3056_7777)"/>
              <defs>
                <filter id="filter0_d_3056_7777" x="0" y="4" width="136" height="136" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dx="-2" dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0.2 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3056_7777"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3056_7777" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_3056_7777" x1="72" y1="62.1483" x2="118.084" y2="19.9845" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint1_linear_3056_7777" x1="72" y1="124.007" x2="118.084" y2="81.8434" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint2_linear_3056_7777" x1="10" y1="124.007" x2="56.0841" y2="81.8434" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint3_linear_3056_7777" x1="86.2207" y1="116.392" x2="81.6011" y2="112.458" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#425064"/>
                  <stop offset="1" stop-color="#5A6E8C"/>
                </linearGradient>
                <linearGradient id="paint4_linear_3056_7777" x1="71.3964" y1="130.124" x2="68.3504" y2="125.977" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="#D1D6DB"/>
                </linearGradient>
                <linearGradient id="paint5_linear_3056_7777" x1="79.4032" y1="123.225" x2="74.7763" y2="118.598" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#FF951A"/>
                  <stop offset="1" stop-color="#FFC730"/>
                </linearGradient>
                <linearGradient id="paint6_linear_3056_7777" x1="10" y1="62.2894" x2="56.0841" y2="20.1256" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint7_linear_3056_7777" x1="39.587" y1="40.1431" x2="47.7451" y2="31.9727" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="0.341176" stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="white"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <div class="item">
            <div class="header">На общей подложке с надсечкой</div>
            <p class="txt">Самый удобный вариант для самостоятельной маркировки. Все стикеры имеют индивидуальную надсечку по контуру, легко отклеиваются по отдельности. Стикеры передаются на общей подложке (на листе).</p>
          </div>
        </div>
        <div class=" flex-container">
          <div class="img item">
            <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g filter="url(#filter0_d_3106_7715)">
                <rect x="11" y="11" width="118" height="118" fill="url(#paint0_linear_3106_7715)"/>
              </g>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M108.186 31.8132C98.4186 22.0455 84.9153 16 69.9995 16C62.8849 16 56.1002 17.3728 49.8699 19.8807L49.6455 19.9863L49.6456 19.9866C49.6458 19.9865 49.646 19.9864 49.6462 19.9863C52.2597 18.9832 54.5037 19.498 56.1141 21.1479L89.7339 60.1266L118.457 83.4637C120.652 85.6458 121.027 87.7231 120.053 90.2824C122.579 84.0342 124 77.1552 124 70C124 55.0843 117.954 41.5942 108.186 31.8132Z" fill="#E5EBEF"/>
              <path opacity="0.3" d="M120.041 90.3143C119.46 91.8323 118.76 93.2843 118.034 94.7098C108.926 112.411 90.5391 124 70.0002 124C40.182 124 16 99.8313 16 70C16 49.2105 27.8798 30.6253 45.9503 21.6495C47.1514 21.0423 48.379 20.4615 49.6462 19.9863" stroke="#00195A" stroke-linejoin="round"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M68.4424 69.5383C50.5171 50.5703 60.3905 25.4249 56.1138 21.1482L118.76 83.7412C111.249 76.2966 86.3808 88.4931 68.4424 69.5383Z" fill="url(#paint1_linear_3106_7715)"/>
              <path d="M46.7829 110.852L45.1754 112.46L41.9368 110.85L40.3272 107.611L41.9347 106.004C43.2733 104.665 45.4432 104.665 46.7823 106.004H46.7829C48.1215 107.343 48.1215 109.513 46.7829 110.852Z" fill="url(#paint2_linear_3106_7715)"/>
              <path d="M34.4387 121.984L27.4232 129L27.0697 122.081L29.8931 119.257L34.4387 121.984Z" fill="url(#paint3_linear_3106_7715)"/>
              <path d="M45.1751 112.46L35.499 122.136L31.0542 121.732L29.4386 118.5L40.3269 107.611L45.1751 112.46Z" fill="url(#paint4_linear_3106_7715)"/>
              <defs>
                <filter id="filter0_d_3106_7715" x="5" y="9" width="126" height="126" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dx="-2" dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0.2 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3106_7715"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3106_7715" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_3106_7715" x1="21.5806" y1="110.591" x2="108.004" y2="24.224" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint1_linear_3106_7715" x1="71.2671" y1="72.2706" x2="88.8887" y2="54.6226" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="0.341176" stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="white"/>
                </linearGradient>
                <linearGradient id="paint2_linear_3106_7715" x1="45.8662" y1="111.533" x2="41.2466" y2="107.599" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#425064"/>
                  <stop offset="1" stop-color="#5A6E8C"/>
                </linearGradient>
                <linearGradient id="paint3_linear_3106_7715" x1="31.0419" y1="125.265" x2="27.9959" y2="121.118" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="#D1D6DB"/>
                </linearGradient>
                <linearGradient id="paint4_linear_3106_7715" x1="39.0487" y1="118.366" x2="34.4218" y2="113.739" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#FF951A"/>
                  <stop offset="1" stop-color="#FFC730"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <div class="item">
            <div class="header">Нарезка с надсечкой</div>
            <p class="txt">Такие стикеры удобны для раздачи или продажи. Каждый стикер имеет индивидуальную надсечку по контуру. Отдается на индивидуальной прямоугольной подложке.</p>
          </div>
        </div>
        <div class=" flex-container">
          <div class="img item">
            <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g filter="url(#filter0_d_3056_7836)">
                <ellipse cx="69.9998" cy="69.6187" rx="53.9998" ry="54" fill="url(#paint0_linear_3056_7836)"/>
              </g>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M108.186 31.4319C98.4186 21.6641 84.9153 15.6187 69.9995 15.6187C62.8849 15.6187 56.1002 16.9914 49.8699 19.4994L49.6455 19.605L49.6456 19.6052C49.6458 19.6051 49.646 19.6051 49.6462 19.605C52.2597 18.6018 54.5037 19.1166 56.1141 20.7666L89.7339 59.7453L118.457 83.0824C120.652 85.2644 121.027 87.3418 120.053 89.901C122.579 83.6529 124 76.7739 124 69.6186C124 54.703 117.954 41.2129 108.186 31.4319Z" fill="#E5EBEF"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M68.4424 69.1567C50.5171 50.1887 60.3905 25.0433 56.1138 20.7666L118.76 83.3596C111.249 75.915 86.3808 88.1115 68.4424 69.1567Z" fill="url(#paint1_linear_3056_7836)"/>
              <path d="M127.897 13.4707L126.29 15.0782L123.051 13.4685L121.441 10.23L123.049 8.623C124.388 7.28387 126.557 7.28387 127.897 8.623H127.897C129.236 9.96161 129.236 12.1321 127.897 13.4707Z" fill="url(#paint2_linear_3056_7836)"/>
              <path d="M115.553 24.603L108.537 31.6185L108.184 24.6994L111.007 21.8755L115.553 24.603Z" fill="url(#paint3_linear_3056_7836)"/>
              <path d="M126.289 15.0782L116.613 24.7548L112.168 24.3509L110.553 21.1182L121.441 10.23L126.289 15.0782Z" fill="url(#paint4_linear_3056_7836)"/>
              <defs>
                <filter id="filter0_d_3056_7836" x="10" y="13.6187" width="116" height="116" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dx="-2" dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0.2 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3056_7836"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3056_7836" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_3056_7836" x1="25.6839" y1="106.77" x2="104.783" y2="27.7223" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint1_linear_3056_7836" x1="71.2671" y1="71.8891" x2="88.8887" y2="54.241" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="0.341176" stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="white"/>
                </linearGradient>
                <linearGradient id="paint2_linear_3056_7836" x1="126.98" y1="14.1514" x2="122.361" y2="10.2177" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#425064"/>
                  <stop offset="1" stop-color="#5A6E8C"/>
                </linearGradient>
                <linearGradient id="paint3_linear_3056_7836" x1="112.156" y1="27.8835" x2="109.11" y2="23.7366" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="#D1D6DB"/>
                </linearGradient>
                <linearGradient id="paint4_linear_3056_7836" x1="120.163" y1="20.9849" x2="115.536" y2="16.358" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#FF951A"/>
                  <stop offset="1" stop-color="#FFC730"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <div class="item">
            <div class="header">Вырубка по форме без поля</div>
            <p class="txt">Каждый стикер отдается на индивидуальной подложке, которая вырублена по форме и размеру самого стикера. Такие стикеры не удобно снимать с подложки, но выглядят они лучше всех. Такие стикеры удобны для раздачи или продажи.</p>
          </div>
        </div>
        <div class=" flex-container">
          <div class="img item">
            <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g filter="url(#filter0_d_3056_7776)">
                <circle cx="70" cy="70" r="62" fill="url(#paint0_linear_3056_7776)"/>
              </g>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M108.186 31.8132C98.4186 22.0455 84.9153 16 69.9995 16C62.8849 16 56.1002 17.3728 49.8699 19.8807L49.6455 19.9863L49.6456 19.9866C49.6458 19.9865 49.646 19.9864 49.6462 19.9863C52.2597 18.9832 54.5037 19.498 56.1141 21.1479L89.7339 60.1266L118.457 83.4637C120.652 85.6458 121.027 87.7231 120.053 90.2824C122.579 84.0342 124 77.1552 124 70C124 55.0843 117.954 41.5942 108.186 31.8132Z" fill="#E5EBEF"/>
              <path opacity="0.3" d="M120.041 90.3143C119.46 91.8323 118.76 93.2843 118.034 94.7098C108.926 112.411 90.5391 124 70.0002 124C40.182 124 16 99.8313 16 70C16 49.2105 27.8798 30.6253 45.9503 21.6495C47.1514 21.0423 48.379 20.4615 49.6462 19.9863" stroke="#00195A" stroke-linejoin="round"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M68.4424 69.5386C50.5171 50.5706 60.3905 25.4251 56.1138 21.1484L118.76 83.7414C111.249 76.2968 86.3808 88.4933 68.4424 69.5386Z" fill="url(#paint1_linear_3056_7776)"/>
              <path d="M134.637 9.85203L133.03 11.4595L129.791 9.84988L128.182 6.61132L129.789 5.00435C131.128 3.66522 133.298 3.66522 134.637 5.00435H134.637C135.976 6.34295 135.976 8.51343 134.637 9.85203Z" fill="url(#paint2_linear_3056_7776)"/>
              <path d="M122.293 20.9844L115.278 27.9999L114.924 21.0808L117.748 18.2568L122.293 20.9844Z" fill="url(#paint3_linear_3056_7776)"/>
              <path d="M133.03 11.4595L123.354 21.1361L118.909 20.7323L117.293 17.4996L128.181 6.61133L133.03 11.4595Z" fill="url(#paint4_linear_3056_7776)"/>
              <defs>
                <filter id="filter0_d_3056_7776" x="2" y="6" width="132" height="132" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dx="-2" dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0.2 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3056_7776"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3056_7776" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_3056_7776" x1="19.1186" y1="112.655" x2="109.936" y2="21.8964" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint1_linear_3056_7776" x1="71.2671" y1="72.2709" x2="88.8887" y2="54.6228" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="0.341176" stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="white"/>
                </linearGradient>
                <linearGradient id="paint2_linear_3056_7776" x1="133.721" y1="10.5327" x2="129.101" y2="6.59904" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#425064"/>
                  <stop offset="1" stop-color="#5A6E8C"/>
                </linearGradient>
                <linearGradient id="paint3_linear_3056_7776" x1="118.896" y1="24.2648" x2="115.85" y2="20.118" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="#D1D6DB"/>
                </linearGradient>
                <linearGradient id="paint4_linear_3056_7776" x1="126.903" y1="17.3662" x2="122.276" y2="12.7393" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#FF951A"/>
                  <stop offset="1" stop-color="#FFC730"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <div class="item">
            <div class="header">Вырубка по форме с полем</div>
            <p class="txt">Стикер имеет индивидуальную надсечку по контуру и выполнен на индивидуальной подложке, которая вырублена по форме. При этом имеет дополнительное поле для удобства снятия наклейки.</p>
          </div>
        </div>
        <div class=" flex-container">
          <div class="img item">
            <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M68.2654 11L129 11V71.7347L94.6794 42.6821L68.2654 11Z" fill="#E5EBEF"/>
              <g filter="url(#filter0_d_3106_7729)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M129 72.06V129H11L11 11L67.9639 11C71.4791 11 74.9942 12.3427 77.6785 15.028C80.3628 17.7134 82.8646 21.2299 82.8646 24.7556L115.25 57.1443C118.765 57.1443 122.289 59.6562 124.973 62.3415C127.658 65.0269 129 68.5434 129 72.06Z" fill="url(#paint0_linear_3106_7729)"/>
              </g>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M115.249 58.2948L81.7041 58.2948V24.7501C81.7041 21.2258 80.3619 17.7107 77.6776 15.0264L124.973 62.3213C122.288 59.637 118.764 58.2948 115.249 58.2948Z" fill="url(#paint1_linear_3106_7729)"/>
              <path d="M46.7829 110.852L45.1754 112.46L41.9368 110.85L40.3272 107.611L41.9347 106.004C43.2733 104.665 45.4432 104.665 46.7823 106.004H46.7829C48.1215 107.343 48.1215 109.513 46.7829 110.852Z" fill="url(#paint2_linear_3106_7729)"/>
              <path d="M34.4387 121.984L27.4232 129L27.0697 122.081L29.8931 119.257L34.4387 121.984Z" fill="url(#paint3_linear_3106_7729)"/>
              <path d="M45.1751 112.46L35.499 122.136L31.0542 121.732L29.4386 118.5L40.3269 107.611L45.1751 112.46Z" fill="url(#paint4_linear_3106_7729)"/>
              <defs>
                <filter id="filter0_d_3106_7729" x="5" y="9" width="126" height="126" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dx="-2" dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0 0.176471 0 0 0 0.2 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3106_7729"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3106_7729" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_3106_7729" x1="21.5806" y1="110.591" x2="108.004" y2="24.2241" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#007DEB"/>
                  <stop offset="1" stop-color="#50B4FF"/>
                </linearGradient>
                <linearGradient id="paint1_linear_3106_7729" x1="82.9823" y1="59.5639" x2="102.594" y2="39.9429" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="0.4" stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="white"/>
                </linearGradient>
                <linearGradient id="paint2_linear_3106_7729" x1="45.8662" y1="111.533" x2="41.2466" y2="107.599" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#425064"/>
                  <stop offset="1" stop-color="#5A6E8C"/>
                </linearGradient>
                <linearGradient id="paint3_linear_3106_7729" x1="31.0419" y1="125.265" x2="27.9959" y2="121.118" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#AABEC8"/>
                  <stop offset="1" stop-color="#D1D6DB"/>
                </linearGradient>
                <linearGradient id="paint4_linear_3106_7729" x1="39.0487" y1="118.366" x2="34.4218" y2="113.739" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#FF951A"/>
                  <stop offset="1" stop-color="#FFC730"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <div class="item">
            <div class="header">Нарезка в размер (прямоугольник)</div>
            <p class="txt">Наклейки порезанные в формат. Стикер режется в формат без надсечки, в случае с бумажной самоклейкой используется заводcкая надсечка подложки.</p>
          </div>
        </div>
      </div>
      CONTENT,
        ]);

        PivotTooltip::query()->create([
            'tooltip_id' => $tooltip->id,
            'calculator_type_id' => 3814,
            'field_id' => 9,
            'is_active' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Tooltip::where('name', 'Виды нарезки наклеек')->delete();
    }
};
