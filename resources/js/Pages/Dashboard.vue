<template>
    <app-layout title="Dashboard">
      <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
          <!--begin::Card widget 20-->
          <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
            style="background-color: #298356;background-image:url('/assets/media/patterns/vector-1.png')">
            <!--begin::Header-->
            <div class="card-header pt-5">
              <!--begin::Title-->
              <div class="card-title d-flex flex-column">
                <!--begin::Amount-->
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects.live_projects }}</span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Projects</span>
                <!--end::Subtitle-->
              </div>
              <!--end::Title-->
            </div>
            <!--end::Header-->

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end pt-0">
              <!--begin::Progress-->
              <div class="d-flex align-items-center flex-column mt-3 w-100">
                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                  <span>43 Pending</span>
                  <span>72%</span>
                </div>

                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                  <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50"
                    aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <!--end::Progress-->
            </div>
            <!--end::Card body-->
          </div>
          <!--end::Card widget 20-->
          <!--begin::Card widget 20-->
          <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
            style="background-color: #7f41f1;background-image:url('/assets/media/patterns/vector-1.png')">
            <!--begin::Header-->
            <div class="card-header pt-5">
              <!--begin::Title-->
              <div class="card-title d-flex flex-column">
                <!--begin::Amount-->
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects.archived_projects }}</span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Archived Projects</span>
                <!--end::Subtitle-->
              </div>
              <!--end::Title-->
            </div>

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end pt-0">
              <!--begin::Progress-->
              <div class="d-flex align-items-center flex-column mt-3 w-100">
                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                  <span>43 Pending</span>
                  <span>72%</span>
                </div>

                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                  <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50"
                    aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <!--end::Progress-->
            </div>
            <!--end::Card body-->
          </div>
          <!--end::Card widget 20-->


        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">

          <!--begin::Card widget 20-->
          <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
            style="background-color: #F1416C;background-image:url('/assets/media/patterns/vector-1.png')">
            <!--begin::Header-->
            <div class="card-header pt-5">
              <!--begin::Title-->
              <div class="card-title d-flex flex-column">
                <!--begin::Amount-->
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects.inactive_projects }}</span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Inactive Projects</span>
                <!--end::Subtitle-->
              </div>
              <!--end::Title-->
            </div>

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end pt-0">
              <!--begin::Progress-->
              <div class="d-flex align-items-center flex-column mt-3 w-100">
                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                  <span>43 Pending</span>
                  <span>72%</span>
                </div>

                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                  <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50"
                    aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <!--end::Progress-->
            </div>
            <!--end::Card body-->
          </div>
          <!--end::Card widget 20-->
          <!--begin::Card widget 20-->
          <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
            style="background-color: #416af1;background-image:url('/assets/media/patterns/vector-1.png')">
            <!--begin::Header-->
            <div class="card-header pt-5">
              <!--begin::Title-->
              <div class="card-title d-flex flex-column">
                <!--begin::Amount-->
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects.closed_projects }}</span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Closed Projects</span>
                <!--end::Subtitle-->
              </div>
              <!--end::Title-->
            </div>

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end pt-0">
              <!--begin::Progress-->
              <div class="d-flex align-items-center flex-column mt-3 w-100">
                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                  <span>43 Pending</span>
                  <span>72%</span>
                </div>

                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                  <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50"
                    aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <!--end::Progress-->
            </div>
            <!--end::Card body-->
          </div>
          <!--end::Card widget 20-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xxl-6">

          <!--begin::Engage widget 10-->
          <div class="card card-flush h-md-100">
            <!--begin::Body-->
            <div
              class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0"
              style="background-position: 100% 50%; background-image:url('/assets/media/stock/900x600/42.png')">
              <!--begin::Wrapper-->
              <div class="mb-10">
                <!--begin::Title-->
                <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                  <span class="me-2">
                    Try our all new Enviroment with
                    <br>
                    <span class="position-relative d-inline-block text-danger">
                      <a href="/../demo1/pages/user-profile/overview.html" class="text-danger opacity-75-hover">Pro Plan</a>

                      <!--begin::Separator-->
                      <span
                        class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                      <!--end::Separator-->
                    </span>
                  </span>
                  for Free
                </div>
                <!--end::Title-->

                <!--begin::Action-->
                <div class="text-center">
                  <a href="#" class="btn btn-sm btn-dark fw-bold" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_upgrade_plan">
                    Upgrade Now
                  </a>
                </div>
                <!--begin::Action-->
              </div>
              <!--begin::Wrapper-->

              <!--begin::Illustration-->
              <img class="mx-auto h-150px h-lg-200px  theme-light-show" src="/assets/media/illustrations/misc/upgrade.svg"
                alt="">
              <img class="mx-auto h-150px h-lg-200px  theme-dark-show"
                src="/assets/media/illustrations/misc/upgrade-dark.svg" alt="">
              <!--end::Illustration-->
            </div>
            <!--end::Body-->
          </div>
          <!--end::Engage widget 10-->

        </div>
        <!--end::Col-->
      </div>

       <!--begin::Row-->
       <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">

          <!--begin::Table widget 14-->
          <div class="card card-flush h-md-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
              <!--begin::Title-->
              <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Projects Stats</span>
              </h3>
              <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-6">
              <!--begin::Table container-->
              <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0 text-left">
                  <!--begin::Table head-->
                  <thead>
                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                      <th class="p-0 pb-3 text-start">PROJECT NAME</th>
                      <th class="p-0 pb-3 text-end">SUPPLIER NAME</th>
                      <th class="p-0 pb-3 text-end">STARTING IP</th>
                      <th class="p-0 pb-3 text-end pe-12">END IP</th>
                      <th class="p-0 pb-3 text-end pe-7">CLIENT BROWSER</th>
                      <th class="p-0 pb-3 text-end">DEVICE</th>
                      <th class="p-0 pb-3 text-end">STATUS</th>
                    </tr>
                  </thead>
                  <!--end::Table head-->

                  <!--begin::Table body-->
                  <tbody>

                    <tr v-for="(surveys, index) in projects.supplier_surveys" :key="index">
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="symbol symbol-50px me-3">
                            <img src="/assets/media/stock/600x600/img-49.jpg" class="" alt="">
                          </div>

                          <div class="d-flex justify-content-start flex-column">
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Mivy App</a>
                            <span class="text-gray-400 fw-semibold d-block fs-7">Jane Cooper</span>
                          </div>
                        </div>
                      </td>

                      <td class="text-end pe-0">
                        <span class="text-gray-600 fw-bold fs-6">$32,400</span>
                      </td>

                      <td class="text-end pe-0">
                        <!--begin::Label-->
                        <span class="badge badge-light-success fs-base">
                          <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span
                              class="path2"></span></i>
                          9.2%
                        </span>
                        <!--end::Label-->

                      </td>

                      <td class="text-end pe-12">
                        <span class="badge py-3 px-4 fs-7 badge-light-primary">In Process</span>
                      </td>

                      <td class="text-end pe-0">
                        <div id="kt_table_widget_14_chart_1" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"
                          style="min-height: 50px;">
                          <div id="apexchartsvp9lpoar" class="apexcharts-canvas apexchartsvp9lpoar apexcharts-theme-light"
                            style="width: 92.25px; height: 50px;"><svg id="SvgjsSvg1006" width="92.25" height="50"
                              xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                              xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS"
                              transform="translate(0, 0)" style="background: transparent;">
                              <g id="SvgjsG1008" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)">
                                <defs id="SvgjsDefs1007">
                                  <clipPath id="gridRectMaskvp9lpoar">
                                    <rect id="SvgjsRect1012" width="98.25" height="52" x="-3" y="-1" rx="0" ry="0"
                                      opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                  </clipPath>
                                  <clipPath id="forecastMaskvp9lpoar"></clipPath>
                                  <clipPath id="nonForecastMaskvp9lpoar"></clipPath>
                                  <clipPath id="gridRectMarkerMaskvp9lpoar">
                                    <rect id="SvgjsRect1013" width="96.25" height="54" x="-2" y="-2" rx="0" ry="0"
                                      opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                  </clipPath>
                                </defs>
                                <g id="SvgjsG1020" class="apexcharts-xaxis" transform="translate(0, 0)">
                                  <g id="SvgjsG1021" class="apexcharts-xaxis-texts-g" transform="translate(0, 4)"></g>
                                </g>
                                <g id="SvgjsG1037" class="apexcharts-grid">
                                  <g id="SvgjsG1038" class="apexcharts-gridlines-horizontal" style="display: none;">
                                    <line id="SvgjsLine1040" x1="0" y1="0" x2="92.25" y2="0" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1041" x1="0" y1="5" x2="92.25" y2="5" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1042" x1="0" y1="10" x2="92.25" y2="10" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1043" x1="0" y1="15" x2="92.25" y2="15" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1044" x1="0" y1="20" x2="92.25" y2="20" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1045" x1="0" y1="25" x2="92.25" y2="25" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1046" x1="0" y1="30" x2="92.25" y2="30" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1047" x1="0" y1="35" x2="92.25" y2="35" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1048" x1="0" y1="40" x2="92.25" y2="40" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1049" x1="0" y1="45" x2="92.25" y2="45" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                    <line id="SvgjsLine1050" x1="0" y1="50" x2="92.25" y2="50" stroke="#e0e0e0"
                                      stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                  </g>
                                  <g id="SvgjsG1039" class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                  <line id="SvgjsLine1052" x1="0" y1="50" x2="92.25" y2="50" stroke="transparent"
                                    stroke-dasharray="0" stroke-linecap="butt"></line>
                                  <line id="SvgjsLine1051" x1="0" y1="1" x2="0" y2="50" stroke="transparent"
                                    stroke-dasharray="0" stroke-linecap="butt"></line>
                                </g>
                                <g id="SvgjsG1014" class="apexcharts-area-series apexcharts-plot-series">
                                  <g id="SvgjsG1015" class="apexcharts-series" seriesName="NetxProfit"
                                    data:longestSeries="true" rel="1" data:realIndex="0">
                                    <path id="SvgjsPath1018"
                                      d="M0 50L0 44.166666666666664C2.483653846153846 44.166666666666664 4.612500000000001 41.666666666666664 7.096153846153847 41.666666666666664C9.579807692307693 41.666666666666664 11.708653846153847 45.833333333333336 14.192307692307693 45.833333333333336C16.67596153846154 45.833333333333336 18.804807692307694 32.5 21.28846153846154 32.5C23.772115384615386 32.5 25.90096153846154 45 28.384615384615387 45C30.868269230769233 45 32.997115384615384 40.83333333333333 35.48076923076923 40.83333333333333C37.96442307692308 40.83333333333333 40.09326923076924 45.833333333333336 42.57692307692308 45.833333333333336C45.06057692307692 45.833333333333336 47.18942307692308 30.833333333333332 49.67307692307693 30.833333333333332C52.156730769230776 30.833333333333332 54.28557692307693 45.833333333333336 56.769230769230774 45.833333333333336C59.252884615384616 45.833333333333336 61.38173076923077 40.83333333333333 63.86538461538462 40.83333333333333C66.34903846153847 40.83333333333333 68.47788461538462 35 70.96153846153847 35C73.44519230769231 35 75.57403846153846 44.166666666666664 78.0576923076923 44.166666666666664C80.54134615384615 44.166666666666664 82.67019230769232 32.5 85.15384615384616 32.5C87.6375 32.5 89.76634615384616 39.166666666666664 92.25 39.166666666666664C92.25 39.166666666666664 92.25 39.166666666666664 92.25 50M92.25 39.166666666666664C92.25 39.166666666666664 92.25 39.166666666666664 92.25 39.166666666666664 "
                                      fill="rgba(255,255,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt"
                                      stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0"
                                      clip-path="url(#gridRectMaskvp9lpoar)"
                                      pathTo="M 0 50L 0 44.166666666666664C 2.483653846153846 44.166666666666664 4.612500000000001 41.666666666666664 7.096153846153847 41.666666666666664C 9.579807692307693 41.666666666666664 11.708653846153847 45.833333333333336 14.192307692307693 45.833333333333336C 16.67596153846154 45.833333333333336 18.804807692307694 32.5 21.28846153846154 32.5C 23.772115384615386 32.5 25.90096153846154 45 28.384615384615387 45C 30.868269230769233 45 32.997115384615384 40.83333333333333 35.48076923076923 40.83333333333333C 37.96442307692308 40.83333333333333 40.09326923076924 45.833333333333336 42.57692307692308 45.833333333333336C 45.06057692307692 45.833333333333336 47.18942307692308 30.833333333333332 49.67307692307693 30.833333333333332C 52.156730769230776 30.833333333333332 54.28557692307693 45.833333333333336 56.769230769230774 45.833333333333336C 59.252884615384616 45.833333333333336 61.38173076923077 40.83333333333333 63.86538461538462 40.83333333333333C 66.34903846153847 40.83333333333333 68.47788461538462 35 70.96153846153847 35C 73.44519230769231 35 75.57403846153846 44.166666666666664 78.0576923076923 44.166666666666664C 80.54134615384615 44.166666666666664 82.67019230769232 32.5 85.15384615384616 32.5C 87.6375 32.5 89.76634615384616 39.166666666666664 92.25 39.166666666666664C 92.25 39.166666666666664 92.25 39.166666666666664 92.25 50M 92.25 39.166666666666664z"
                                      pathFrom="M -1 50L -1 50L 7.096153846153847 50L 14.192307692307693 50L 21.28846153846154 50L 28.384615384615387 50L 35.48076923076923 50L 42.57692307692308 50L 49.67307692307693 50L 56.769230769230774 50L 63.86538461538462 50L 70.96153846153847 50L 78.0576923076923 50L 85.15384615384616 50L 92.25 50">
                                    </path>
                                    <path id="SvgjsPath1019"
                                      d="M0 44.166666666666664C2.483653846153846 44.166666666666664 4.612500000000001 41.666666666666664 7.096153846153847 41.666666666666664C9.579807692307693 41.666666666666664 11.708653846153847 45.833333333333336 14.192307692307693 45.833333333333336C16.67596153846154 45.833333333333336 18.804807692307694 32.5 21.28846153846154 32.5C23.772115384615386 32.5 25.90096153846154 45 28.384615384615387 45C30.868269230769233 45 32.997115384615384 40.83333333333333 35.48076923076923 40.83333333333333C37.96442307692308 40.83333333333333 40.09326923076924 45.833333333333336 42.57692307692308 45.833333333333336C45.06057692307692 45.833333333333336 47.18942307692308 30.833333333333332 49.67307692307693 30.833333333333332C52.156730769230776 30.833333333333332 54.28557692307693 45.833333333333336 56.769230769230774 45.833333333333336C59.252884615384616 45.833333333333336 61.38173076923077 40.83333333333333 63.86538461538462 40.83333333333333C66.34903846153847 40.83333333333333 68.47788461538462 35 70.96153846153847 35C73.44519230769231 35 75.57403846153846 44.166666666666664 78.0576923076923 44.166666666666664C80.54134615384615 44.166666666666664 82.67019230769232 32.5 85.15384615384616 32.5C87.6375 32.5 89.76634615384616 39.166666666666664 92.25 39.166666666666664C92.25 39.166666666666664 92.25 39.166666666666664 92.25 39.166666666666664 "
                                      fill="none" fill-opacity="1" stroke="#50cd89" stroke-opacity="1" stroke-linecap="butt"
                                      stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0"
                                      clip-path="url(#gridRectMaskvp9lpoar)"
                                      pathTo="M 0 44.166666666666664C 2.483653846153846 44.166666666666664 4.612500000000001 41.666666666666664 7.096153846153847 41.666666666666664C 9.579807692307693 41.666666666666664 11.708653846153847 45.833333333333336 14.192307692307693 45.833333333333336C 16.67596153846154 45.833333333333336 18.804807692307694 32.5 21.28846153846154 32.5C 23.772115384615386 32.5 25.90096153846154 45 28.384615384615387 45C 30.868269230769233 45 32.997115384615384 40.83333333333333 35.48076923076923 40.83333333333333C 37.96442307692308 40.83333333333333 40.09326923076924 45.833333333333336 42.57692307692308 45.833333333333336C 45.06057692307692 45.833333333333336 47.18942307692308 30.833333333333332 49.67307692307693 30.833333333333332C 52.156730769230776 30.833333333333332 54.28557692307693 45.833333333333336 56.769230769230774 45.833333333333336C 59.252884615384616 45.833333333333336 61.38173076923077 40.83333333333333 63.86538461538462 40.83333333333333C 66.34903846153847 40.83333333333333 68.47788461538462 35 70.96153846153847 35C 73.44519230769231 35 75.57403846153846 44.166666666666664 78.0576923076923 44.166666666666664C 80.54134615384615 44.166666666666664 82.67019230769232 32.5 85.15384615384616 32.5C 87.6375 32.5 89.76634615384616 39.166666666666664 92.25 39.166666666666664"
                                      pathFrom="M -1 50L -1 50L 7.096153846153847 50L 14.192307692307693 50L 21.28846153846154 50L 28.384615384615387 50L 35.48076923076923 50L 42.57692307692308 50L 49.67307692307693 50L 56.769230769230774 50L 63.86538461538462 50L 70.96153846153847 50L 78.0576923076923 50L 85.15384615384616 50L 92.25 50"
                                      fill-rule="evenodd"></path>
                                    <g id="SvgjsG1016" class="apexcharts-series-markers-wrap" data:realIndex="0"></g>
                                  </g>
                                  <g id="SvgjsG1017" class="apexcharts-datalabels" data:realIndex="0"></g>
                                </g>
                                <line id="SvgjsLine1053" x1="0" y1="0" x2="92.25" y2="0" stroke="#b6b6b6"
                                  stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"
                                  class="apexcharts-ycrosshairs"></line>
                                <line id="SvgjsLine1054" x1="0" y1="0" x2="92.25" y2="0" stroke-dasharray="0"
                                  stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                <g id="SvgjsG1055" class="apexcharts-yaxis-annotations"></g>
                                <g id="SvgjsG1056" class="apexcharts-xaxis-annotations"></g>
                                <g id="SvgjsG1057" class="apexcharts-point-annotations"></g>
                              </g>
                              <g id="SvgjsG1036" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                              <g id="SvgjsG1009" class="apexcharts-annotations"></g>
                            </svg>
                            <div class="apexcharts-legend" style="max-height: 25px;"></div>
                          </div>
                        </div>
                      </td>

                      <td class="text-end">
                        <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                          <i class="ki-duotone ki-black-right fs-2 text-gray-500"></i> </a>
                      </td>
                    </tr>
                  </tbody>
                  <!--end::Table body-->
                </table>
              </div>
              <!--end::Table-->
            </div>
            <!--end: Card Body-->
          </div>
          <!--end::Table widget 14-->
        </div>
        <!--end::Col-->
      </div>
      <!--end::Row-->
      <!--begin::Row-->
      <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-6">
          <!--begin::Card widget 18-->
          <div class="card card-flush h-md-100">
            <!--begin::Body-->
            <div class="card-body py-9">
              <!--begin::Row-->
              <div class="row gx-9 h-100">
                <!--begin::Col-->
                <div class="col-sm-6 mb-10 mb-sm-0">
                  <!--begin::Image-->
                  <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-400px min-h-sm-100 h-100"
                    style="background-size: 100% 100%;background-image:url('/assets/media/stock/600x600/img-33.jpg')">
                  </div>
                  <!--end::Image-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-sm-6">
                  <!--begin::Wrapper-->
                  <div class="d-flex flex-column h-100">
                    <!--begin::Header-->
                    <div class="mb-7">
                      <!--begin::Headin-->
                      <div class="d-flex flex-stack mb-6">
                        <!--begin::Title-->
                        <div class="flex-shrink-0 me-5">
                          <span class="text-gray-400 fs-7 fw-bold me-2 d-block lh-1 pb-1">Featured</span>

                          <span class="text-gray-800 fs-1 fw-bold">9 Degree</span>
                        </div>
                        <!--end::Title-->

                        <span class="badge badge-light-primary flex-shrink-0 align-self-center py-3 px-4 fs-7">In
                          Process</span>
                      </div>
                      <!--end::Heading-->

                      <!--begin::Items-->
                      <div class="d-flex align-items-center flex-wrap d-grid gap-2">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center me-5 me-xl-13">
                          <!--begin::Symbol-->
                          <div class="symbol symbol-30px symbol-circle me-3">
                            <img src="/assets/media/avatars/300-3.jpg" class="" alt="">
                          </div>
                          <!--end::Symbol-->

                          <!--begin::Info-->
                          <div class="m-0">
                            <span class="fw-semibold text-gray-400 d-block fs-8">Manager</span>
                            <a href="/../demo1/pages/user-profile/overview.html"
                              class="fw-bold text-gray-800 text-hover-primary fs-7">Robert Fox</a>
                          </div>
                          <!--end::Info-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                          <!--begin::Symbol-->
                          <div class="symbol symbol-30px symbol-circle me-3">
                            <span class="symbol-label bg-success">
                              <i class="ki-duotone ki-abstract-41 fs-5 text-white"><span class="path1"></span><span
                                  class="path2"></span></i> </span>
                          </div>
                          <!--end::Symbol-->

                          <!--begin::Info-->
                          <div class="m-0">
                            <span class="fw-semibold text-gray-400 d-block fs-8">Budget</span>
                            <span class="fw-bold text-gray-800 fs-7">$64.800</span>
                          </div>
                          <!--end::Info-->
                        </div>
                        <!--end::Item-->
                      </div>
                      <!--end::Items-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="mb-6">
                      <!--begin::Text-->
                      <span class="fw-semibold text-gray-600 fs-6 mb-8 d-block">
                        Flat cartoony illustrations with vivid
                        unblended colors and asymmetrical beautiful purple hair lady
                      </span>
                      <!--end::Text-->

                      <!--begin::Stats-->
                      <div class="d-flex">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 me-6 mb-3">
                          <!--begin::Date-->
                          <span class="fs-6 text-gray-700 fw-bold">Feb 6, 2021 </span>
                          <!--end::Date-->

                          <!--begin::Label-->
                          <div class="fw-semibold text-gray-400">Due Date</div>
                          <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 mb-3">
                          <!--begin::Number-->
                          <span class="fs-6 text-gray-700 fw-bold">$<span class="ms-n1 counted" data-kt-countup="true"
                              data-kt-countup-value="284,900.00" data-kt-initialized="1">284,900</span></span>
                          <!--end::Number-->

                          <!--begin::Label-->
                          <div class="fw-semibold text-gray-400">Budget</div>
                          <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                      </div>
                      <!--end::Stats-->
                    </div>
                    <!--end::Body-->

                    <!--begin::Footer-->
                    <div class="d-flex flex-stack mt-auto bd-highlight">
                      <!--begin::Users group-->
                      <div class="symbol-group symbol-hover flex-nowrap">
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" aria-label="Melody Macy"
                          data-bs-original-title="Melody Macy" data-kt-initialized="1">
                          <img alt="Pic" src="/assets/media/avatars/300-2.jpg">
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" aria-label="Michael Eberon"
                          data-bs-original-title="Michael Eberon" data-kt-initialized="1">
                          <img alt="Pic" src="/assets/media/avatars/300-3.jpg">
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                          data-bs-original-title="Susan Redwood" data-kt-initialized="1">
                          <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                        </div>

                      </div>
                      <!--end::Users group-->

                      <!--begin::Actions-->
                      <a href="/../demo1/apps/projects/project.html"
                        class="d-flex align-items-center text-primary opacity-75-hover fs-6 fw-semibold">
                        View Project

                        <i class="ki-duotone ki-exit-right-corner fs-4 ms-1"><span class="path1"></span><span
                            class="path2"></span></i>
                      </a>
                      <!--end::Actions-->
                    </div>
                    <!--end::Footer-->
                  </div>
                  <!--end::Wrapper-->
                </div>
                <!--end::Col-->
              </div>
              <!--end::Row-->
            </div>
            <!--end::Body-->
          </div>
          <!--end::Card widget 18-->


        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xxl-6">
          <!--begin::Engage widget 8-->
          <div class="card border-0 h-md-100" style="background: linear-gradient(112.14deg, #00D2FF 0%, #3A7BD5 100%)">
            <!--begin::Body-->
            <div class="card-body">
              <!--begin::Row-->
              <div class="row align-items-center h-100">
                <!--begin::Col-->
                <div class="col-7 ps-xl-13">
                  <!--begin::Title-->
                  <div class="text-white mb-6 pt-6">
                    <span class="fs-4 fw-semibold me-2 d-block lh-1 pb-2 opacity-75">Get best offer</span>

                    <span class="fs-2qx fw-bold">Upgrade Your Plan</span>
                  </div>
                  <!--end::Title-->

                  <!--begin::Text-->
                  <span class="fw-semibold text-white fs-6 mb-8 d-block opacity-75">
                    Flat cartoony and illustrations with vivid unblended purple hair lady
                  </span>
                  <!--end::Text-->

                  <!--begin::Items-->
                  <div class="d-flex align-items-center flex-wrap d-grid gap-2 mb-10 mb-xl-20">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center me-5 me-xl-13">
                      <!--begin::Symbol-->
                      <div class="symbol symbol-30px symbol-circle me-3">
                        <span class="symbol-label" style="background: #35C7FF">
                          <i class="ki-duotone ki-abstract-41 fs-5 text-white"><span class="path1"></span><span
                              class="path2"></span></i> </span>
                      </div>
                      <!--end::Symbol-->

                      <!--begin::Info-->
                      <div class="text-white">
                        <span class="fw-semibold d-block fs-8 opacity-75">Projects</span>
                        <span class="fw-bold fs-7">Up to 500</span>
                      </div>
                      <!--end::Info-->
                    </div>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                      <!--begin::Symbol-->
                      <div class="symbol symbol-30px symbol-circle me-3">
                        <span class="symbol-label" style="background: #35C7FF">
                          <i class="ki-duotone ki-abstract-26 fs-5 text-white"><span class="path1"></span><span
                              class="path2"></span></i> </span>
                      </div>
                      <!--end::Symbol-->

                      <!--begin::Info-->
                      <div class="text-white">
                        <span class="fw-semibold opacity-75 d-block fs-8">Tasks</span>
                        <span class="fw-bold fs-7">Unlimited</span>
                      </div>
                      <!--end::Info-->
                    </div>
                    <!--end::Item-->
                  </div>
                  <!--end::Items-->

                  <!--begin::Action-->
                  <div class="d-flex flex-column flex-sm-row d-grid gap-2">
                    <a href="#" class="btn btn-success flex-shrink-0 me-lg-2" data-bs-toggle="modal"
                      data-bs-target="#kt_modal_upgrade_plan">Upgrade Plan</a>
                    <a href="#" class="btn btn-primary flex-shrink-0" style="background: rgba(255, 255, 255, 0.2)"
                      data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Read Guides</a>
                  </div>
                  <!--end::Action-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-5 pt-10">
                  <!--begin::Illustration-->
                  <div class="bgi-no-repeat bgi-size-contain bgi-position-x-end h-225px"
                    style="background-image:url('/assets/media/svg/illustrations/easy/5.svg')">
                  </div>
                  <!--end::Illustration-->
                </div>
                <!--end::Col-->
              </div>
              <!--end::Row-->
            </div>
            <!--end::Body-->
          </div>
          <!--end::Engage widget 8-->

        </div>
        <!--end::Col-->
      </div>



      <!--begin::Row-->
      <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4">

          <!--begin::Engage widget 1-->
          <div class="card h-md-100" dir="ltr">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column flex-center">
              <!--begin::Heading-->
              <div class="mb-2">
                <!--begin::Title-->
                <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                  Have your tried <br> new
                  <span class="fw-bolder"> Invoice Manager?</span>
                </h1>
                <!--end::Title-->

                <!--begin::Illustration-->
                <div class="py-10 text-center">
                  <img src="/assets/media/svg/illustrations/easy/2.svg" class="theme-light-show w-200px" alt="">
                  <img src="/assets/media/svg/illustrations/easy/2-dark.svg" class="theme-dark-show w-200px" alt="">
                </div>
                <!--end::Illustration-->
              </div>
              <!--end::Heading-->

              <!--begin::Links-->
              <div class="text-center mb-1">
                <!--begin::Link-->
                <a class="btn btn-sm btn-primary me-2" data-bs-target="#kt_modal_new_address" data-bs-toggle="modal">
                  Try Now </a>
                <!--end::Link-->

                <!--begin::Link-->
                <a class="btn btn-sm btn-light" href="/../demo1/apps/user-management/users/view.html">
                  Learn More </a>
                <!--end::Link-->
              </div>
              <!--end::Links-->
            </div>
            <!--end::Body-->
          </div>
          <!--end::Engage widget 1-->

        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-8">
          <!--begin::Timeline Widget 4-->
          <div class="card h-md-100">
            <!--begin::Card header-->
            <div class="card-header position-relative py-0 border-bottom-1">
              <!--begin::Card title-->
              <h3 class="card-title text-gray-800 fw-bold">Active Tasks</h3>
              <!--end::Card title-->

              <!--begin::Tabs-->
              <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4" role="tablist">
                <!--begin::Nav item-->
                <li class="nav-item p-0 ms-0" role="presentation">
                  <a class="nav-link btn btn-color-gray-400 flex-center px-3 active" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#kt_timeline_widget_4_tab_day" aria-selected="true" role="tab">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Day</span>
                    <!--end::Title-->

                    <!--begin::Bullet-->
                    <span
                      class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                  </a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item p-0 ms-0" role="presentation">
                  <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#kt_timeline_widget_4_tab_week" aria-selected="false" tabindex="-1"
                    role="tab">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Week</span>
                    <!--end::Title-->

                    <!--begin::Bullet-->
                    <span
                      class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                  </a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item p-0 ms-0" role="presentation">
                  <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#kt_timeline_widget_4_tab_month" aria-selected="false" tabindex="-1"
                    role="tab">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Month</span>
                    <!--end::Title-->

                    <!--begin::Bullet-->
                    <span
                      class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                  </a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item p-0 ms-0" role="presentation">
                  <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#kt_timeline_widget_4_tab_2022" aria-selected="false" tabindex="-1"
                    role="tab">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">2022</span>
                    <!--end::Title-->

                    <!--begin::Bullet-->
                    <span
                      class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                  </a>
                </li>
                <!--end::Nav item-->
              </ul>
              <!--end::Tabs-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pb-0">
              <!--begin::Tab content-->
              <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane active blockui" id="kt_timeline_widget_4_tab_day" role="tabpanel"
                  aria-labelledby="day-tab" data-kt-timeline-widget-4-blockui="true" style="">
                  <div class="table-responsive pb-10">
                    <!--begin::Timeline-->
                    <div id="kt_timeline_widget_4_1" class="vis-timeline-custom h-350px min-w-700px"
                      data-kt-timeline-widget-4-image-root="/assets/media/" style="position: relative;">
                      <div class="vis-timeline vis-bottom vis-ltr"
                        style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); visibility: visible; height: 354px;">
                        <div class="vis-panel vis-background" style="height: 354px; width: 771px; left: 0px; top: 0px;">
                        </div>
                        <div class="vis-panel vis-background vis-vertical"
                          style="height: 354px; width: 645px; left: 128px; top: 0px;">
                          <div class="vis-axis" style="top: 304px; left: 0px;">
                            <div class="vis-group"></div>
                            <div class="vis-group"></div>
                            <div class="vis-group"></div>
                            <div class="vis-group"></div>
                          </div>
                          <div class="vis-time-axis vis-background">
                            <div class="vis-grid vis-vertical vis-minor vis-h14  vis-today  vis-even"
                              style="width: 208.333px; height: 330px; transform: translate(-163.847px, -1px);"></div>
                            <div class="vis-grid vis-vertical vis-minor vis-h15  vis-today  vis-odd"
                              style="width: 208.333px; height: 330px; transform: translate(44.4863px, -1px);"></div>
                            <div class="vis-grid vis-vertical vis-minor vis-h16  vis-today  vis-even"
                              style="width: 208.333px; height: 330px; transform: translate(252.82px, -1px);"></div>
                            <div class="vis-grid vis-vertical vis-minor vis-h17  vis-today  vis-odd"
                              style="width: 208.333px; height: 330px; transform: translate(461.153px, -1px);"></div>
                          </div>
                        </div>
                        <div class="vis-panel vis-background vis-horizontal"
                          style="height: 305px; width: 771px; left: 0px; top: -1px;"></div>
                        <div class="vis-panel vis-center"
                          style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); height: 305px; width: 645px; left: 127px; top: -1px;">
                          <div class="vis-content" style="left: 0px; transform: translateY(0px);">
                            <div class="vis-itemset" style="height: 303px;">
                              <div class="vis-background">
                                <div class="vis-group" style="height: 0px;">
                                  <div style="visibility: hidden; position: absolute;"></div>
                                </div>
                                <div class="vis-group" style="height: 75px;">
                                  <div style="visibility: hidden; position: absolute;"></div>
                                </div>
                                <div class="vis-group" style="height: 75px;">
                                  <div style="visibility: hidden; position: absolute;"></div>
                                </div>
                                <div class="vis-group" style="height: 75px;">
                                  <div style="visibility: hidden; position: absolute;"></div>
                                </div>
                                <div class="vis-group" style="height: 78px;">
                                  <div style="visibility: hidden; position: absolute;"></div>
                                </div>
                              </div>
                              <div class="vis-foreground">
                                <div class="vis-group" style="height: 75px;">
                                  <div class="vis-item vis-range vis-readonly"
                                    style="transform: translateX(10px); width: 312.5px; top: 17.5px;">
                                    <div class="vis-item-overflow">
                                      <div class="vis-item-content" style="transform: translateX(0px);">
                                        <div
                                          class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">
                                          <div
                                            class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1"
                                            style="width:60%;"></div>

                                          <div class="d-flex align-items-center position-relative z-index-2">
                                            <div class="symbol-group symbol-hover flex-nowrap me-3">
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-6.jpg"></div>
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-1.jpg"></div>
                                            </div>

                                            <a href="#" class="fw-bold text-white text-hover-dark">Meeting</a>
                                          </div>

                                          <div
                                            class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">
                                            60%
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="vis-item-visible-frame"></div>
                                  </div>
                                </div>
                                <div class="vis-group" style="height: 75px;">
                                  <div class="vis-item vis-range vis-readonly"
                                    style="transform: translateX(218.333px); width: 208.333px; top: 17.5px;">
                                    <div class="vis-item-overflow">
                                      <div class="vis-item-content" style="transform: translateX(0px);">
                                        <div
                                          class="rounded-pill bg-light-success d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">
                                          <div
                                            class="position-absolute rounded-pill d-block bg-success start-0 top-0 h-100 z-index-1"
                                            style="width:47%;"></div>

                                          <div class="d-flex align-items-center position-relative z-index-2">
                                            <div class="symbol-group symbol-hover flex-nowrap me-3">
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-2.jpg"></div>
                                            </div>

                                            <a href="#" class="fw-bold text-white text-hover-dark">Testing</a>
                                          </div>

                                          <div
                                            class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">
                                            47%
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="vis-item-visible-frame"></div>
                                  </div>
                                </div>
                                <div class="vis-group" style="height: 75px;">
                                  <div class="vis-item vis-range vis-readonly"
                                    style="transform: translateX(114.167px); width: 416.667px; top: 17.5px;">
                                    <div class="vis-item-overflow">
                                      <div class="vis-item-content" style="transform: translateX(0px);">
                                        <div
                                          class="rounded-pill bg-light-danger d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">
                                          <div
                                            class="position-absolute rounded-pill d-block bg-danger start-0 top-0 h-100 z-index-1"
                                            style="width:55%;"></div>

                                          <div class="d-flex align-items-center position-relative z-index-2">
                                            <div class="symbol-group symbol-hover flex-nowrap me-3">
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-5.jpg"></div>
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-20.jpg"></div>
                                            </div>

                                            <a href="#" class="fw-bold text-white text-hover-dark">Landing page</a>
                                          </div>

                                          <div
                                            class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">
                                            55%
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="vis-item-visible-frame"></div>
                                  </div>
                                </div>
                                <div class="vis-group" style="height: 78px;">
                                  <div class="vis-item vis-range vis-readonly"
                                    style="transform: translateX(322.5px); width: 312.5px; top: 18px;">
                                    <div class="vis-item-overflow">
                                      <div class="vis-item-content" style="transform: translateX(0px);">
                                        <div
                                          class="rounded-pill bg-light-info d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">
                                          <div
                                            class="position-absolute rounded-pill d-block bg-info start-0 top-0 h-100 z-index-1"
                                            style="width:75%;"></div>

                                          <div class="d-flex align-items-center position-relative z-index-2">
                                            <div class="symbol-group symbol-hover flex-nowrap me-3">
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-23.jpg"></div>
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-12.jpg"></div>
                                              <div class="symbol symbol-circle symbol-25px"><img alt=""
                                                  src="/assets/media/avatars/300-9.jpg"></div>
                                            </div>

                                            <a href="#" class="fw-bold text-white text-hover-dark">Products module</a>
                                          </div>

                                          <div
                                            class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">
                                            75%
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="vis-item-visible-frame"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="vis-shadow vis-top" style="visibility: hidden;"></div>
                          <div class="vis-shadow vis-bottom" style="visibility: hidden;"></div>
                        </div>
                        <div class="vis-panel vis-left"
                          style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); height: 305px; left: 0px; top: -1px;">
                          <div class="vis-content" style="left: 0px; top: 0px;">
                            <div class="vis-labelset">
                              <div class="vis-label vis-group-level-0" title="" style="height: 75px;">
                                <div class="vis-inner">Research</div>
                              </div>
                              <div class="vis-label vis-group-level-0" title="" style="height: 75px;">
                                <div class="vis-inner">Phase 2.6 QA</div>
                              </div>
                              <div class="vis-label vis-group-level-0" title="" style="height: 75px;">
                                <div class="vis-inner">UI Design</div>
                              </div>
                              <div class="vis-label vis-group-level-0" title="" style="height: 78px;">
                                <div class="vis-inner">Development</div>
                              </div>
                            </div>
                          </div>
                          <div class="vis-shadow vis-top" style="visibility: hidden;"></div>
                          <div class="vis-shadow vis-bottom" style="visibility: hidden;"></div>
                        </div>
                        <div class="vis-panel vis-right" style="height: 305px; left: 772px; top: -1px;">
                          <div class="vis-content" style="left: 0px; top: 0px;"></div>
                          <div class="vis-shadow vis-top" style="visibility: hidden;"></div>
                          <div class="vis-shadow vis-bottom" style="visibility: hidden;"></div>
                        </div>
                        <div class="vis-panel vis-top" style="width: 645px; left: 127px; top: 0px;"></div>
                        <div class="vis-panel vis-bottom" style="width: 645px; left: 127px; top: 304px;">
                          <div class="vis-time-axis vis-foreground" style="height: 50px;">
                            <div class="vis-text vis-minor vis-measure" style="position: absolute;">0</div>
                            <div class="vis-text vis-major vis-measure" style="position: absolute;">0</div>
                            <div class="vis-text vis-minor vis-h14  vis-today  vis-even"
                              style="transform: translate(-163.347px, 0px); width: 208.333px;">14:00</div>
                            <div class="vis-text vis-minor vis-h15  vis-today  vis-odd"
                              style="transform: translate(44.9863px, 0px); width: 208.333px;">15:00</div>
                            <div class="vis-text vis-minor vis-h16  vis-today  vis-even"
                              style="transform: translate(253.32px, 0px); width: 208.333px;">16:00</div>
                            <div class="vis-text vis-minor vis-h17  vis-today  vis-odd"
                              style="transform: translate(461.653px, 0px); width: 208.333px;">17:00</div>
                            <div class="vis-text vis-major vis-h17  vis-today  vis-odd"
                              style="transform: translate(0px, 25px);">
                              <div>Thu 15 June</div>
                            </div>
                          </div>
                        </div>
                        <div class="vis-rolling-mode-btn" style="visibility: hidden;"></div>
                      </div>
                    </div>
                    <!--end::Timeline-->
                  </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane blockui" id="kt_timeline_widget_4_tab_week" role="tabpanel" aria-labelledby="week-tab"
                  data-kt-timeline-widget-4-blockui="true" style="overflow: hidden;">
                  <div class="table-responsive pb-10">
                    <!--begin::Timeline-->
                    <div id="kt_timeline_widget_4_2" class="vis-timeline-custom h-350px min-w-700px"
                      data-kt-timeline-widget-4-image-root="/assets/media/"></div>
                    <!--end::Timeline-->
                  </div>
                  <div class="blockui-overlay bg-body" style="z-index: 1;"><span class="spinner-border text-primary"></span>
                  </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane blockui" id="kt_timeline_widget_4_tab_month" role="tabpanel"
                  aria-labelledby="month-tab" data-kt-timeline-widget-4-blockui="true" style="overflow: hidden;">
                  <div class="table-responsive pb-10">
                    <!--begin::Timeline-->
                    <div id="kt_timeline_widget_4_3" class="vis-timeline-custom h-350px min-w-700px"
                      data-kt-timeline-widget-4-image-root="/assets/media/"></div>
                    <!--end::Timeline-->
                  </div>
                  <div class="blockui-overlay bg-body" style="z-index: 1;"><span class="spinner-border text-primary"></span>
                  </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane blockui" id="kt_timeline_widget_4_tab_2022" role="tabpanel" aria-labelledby="week-tab"
                  data-kt-timeline-widget-4-blockui="true" style="overflow: hidden;">
                  <div class="table-responsive pb-10">
                    <!--begin::Timeline-->
                    <div id="kt_timeline_widget_4_4" class="vis-timeline-custom h-350px min-w-700px"
                      data-kt-timeline-widget-4-image-root="/assets/media/"></div>
                    <!--end::Timeline-->
                  </div>
                  <div class="blockui-overlay bg-body" style="z-index: 1;"><span class="spinner-border text-primary"></span>
                  </div>
                </div>
                <!--end::Tab pane-->
              </div>
              <!--end::Tab content-->
            </div>
            <!--end::Card body-->
          </div>
          <!--end::Timeline Widget 1-->
        </div>
        <!--end::Col-->
      </div>
      <!--end::Row-->
    </app-layout>
  </template>

  <script>
  import { defineComponent } from "vue"
  import AppLayout from "@/Layouts/AppLayout.vue"
  import Welcome from "@/Jetstream/Welcome.vue"

  export default defineComponent({
    components: {
      AppLayout,
      Welcome
    },
    props: ['projects']
  });
  </script>
