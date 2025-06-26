@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Sales <span>| Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>145</h6>
                                        <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Revenue <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>$3,264</h6>
                                        <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Customers <span>| This Year</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>1244</h6>
                                        <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Reports <span>/Today</span></h5>

                                <!-- Line Chart -->
                                <div id="reportsChart" style="min-height: 365px;">
                                    <div id="apexchartsbq91ag8cg" class="apexcharts-canvas apexchartsbq91ag8cg apexcharts-theme-light" style="width: 869px; height: 350px;"><svg id="SvgjsSvg1492" width="869" height="350" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                            <foreignObject x="0" y="0" width="869" height="350">
                                                <div class="apexcharts-legend apexcharts-align-center apx-legend-position-bottom" xmlns="http://www.w3.org/1999/xhtml" style="inset: auto 0px 1px; position: absolute; max-height: 175px;">
                                                    <div class="apexcharts-legend-series" rel="1" seriesname="Sales" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="1" data:collapsed="false" style="background: rgb(65, 84, 241) !important; color: rgb(65, 84, 241); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="1" i="0" data:default-text="Sales" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Sales</span></div>
                                                    <div class="apexcharts-legend-series" rel="2" seriesname="Revenue" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="2" data:collapsed="false" style="background: rgb(46, 202, 106) !important; color: rgb(46, 202, 106); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="2" i="1" data:default-text="Revenue" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Revenue</span></div>
                                                    <div class="apexcharts-legend-series" rel="3" seriesname="Customers" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="3" data:collapsed="false" style="background: rgb(255, 119, 29) !important; color: rgb(255, 119, 29); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="3" i="2" data:default-text="Customers" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Customers</span></div>
                                                </div>
                                                <style type="text/css">
                                                    .apexcharts-legend {
                                                        display: flex;
                                                        overflow: auto;
                                                        padding: 0 10px;
                                                    }

                                                    .apexcharts-legend.apx-legend-position-bottom,
                                                    .apexcharts-legend.apx-legend-position-top {
                                                        flex-wrap: wrap
                                                    }

                                                    .apexcharts-legend.apx-legend-position-right,
                                                    .apexcharts-legend.apx-legend-position-left {
                                                        flex-direction: column;
                                                        bottom: 0;
                                                    }

                                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                                    .apexcharts-legend.apx-legend-position-right,
                                                    .apexcharts-legend.apx-legend-position-left {
                                                        justify-content: flex-start;
                                                    }

                                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                                        justify-content: center;
                                                    }

                                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                                        justify-content: flex-end;
                                                    }

                                                    .apexcharts-legend-series {
                                                        cursor: pointer;
                                                        line-height: normal;
                                                    }

                                                    .apexcharts-legend.apx-legend-position-bottom .apexcharts-legend-series,
                                                    .apexcharts-legend.apx-legend-position-top .apexcharts-legend-series {
                                                        display: flex;
                                                        align-items: center;
                                                    }

                                                    .apexcharts-legend-text {
                                                        position: relative;
                                                        font-size: 14px;
                                                    }

                                                    .apexcharts-legend-text *,
                                                    .apexcharts-legend-marker * {
                                                        pointer-events: none;
                                                    }

                                                    .apexcharts-legend-marker {
                                                        position: relative;
                                                        display: inline-block;
                                                        cursor: pointer;
                                                        margin-right: 3px;
                                                        border-style: solid;
                                                    }

                                                    .apexcharts-legend.apexcharts-align-right .apexcharts-legend-series,
                                                    .apexcharts-legend.apexcharts-align-left .apexcharts-legend-series {
                                                        display: inline-block;
                                                    }

                                                    .apexcharts-legend-series.apexcharts-no-click {
                                                        cursor: auto;
                                                    }

                                                    .apexcharts-legend .apexcharts-hidden-zero-series,
                                                    .apexcharts-legend .apexcharts-hidden-null-series {
                                                        display: none !important;
                                                    }

                                                    .apexcharts-inactive-legend {
                                                        opacity: 0.45;
                                                    }
                                                </style>
                                            </foreignObject>
                                            <rect id="SvgjsRect1500" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                            <g id="SvgjsG1623" class="apexcharts-yaxis" rel="0" transform="translate(9.25, 0)">
                                                <g id="SvgjsG1624" class="apexcharts-yaxis-texts-g"><text id="SvgjsText1626" font-family="Helvetica, Arial, sans-serif" x="20" y="33.666666666666664" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1627">90</tspan>
                                                        <title>90</title>
                                                    </text><text id="SvgjsText1629" font-family="Helvetica, Arial, sans-serif" x="20" y="63.68888888888888" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1630">80</tspan>
                                                        <title>80</title>
                                                    </text><text id="SvgjsText1632" font-family="Helvetica, Arial, sans-serif" x="20" y="93.71111111111111" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1633">70</tspan>
                                                        <title>70</title>
                                                    </text><text id="SvgjsText1635" font-family="Helvetica, Arial, sans-serif" x="20" y="123.73333333333333" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1636">60</tspan>
                                                        <title>60</title>
                                                    </text><text id="SvgjsText1638" font-family="Helvetica, Arial, sans-serif" x="20" y="153.75555555555556" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1639">50</tspan>
                                                        <title>50</title>
                                                    </text><text id="SvgjsText1641" font-family="Helvetica, Arial, sans-serif" x="20" y="183.77777777777777" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1642">40</tspan>
                                                        <title>40</title>
                                                    </text><text id="SvgjsText1644" font-family="Helvetica, Arial, sans-serif" x="20" y="213.79999999999998" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1645">30</tspan>
                                                        <title>30</title>
                                                    </text><text id="SvgjsText1647" font-family="Helvetica, Arial, sans-serif" x="20" y="243.8222222222222" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1648">20</tspan>
                                                        <title>20</title>
                                                    </text><text id="SvgjsText1650" font-family="Helvetica, Arial, sans-serif" x="20" y="273.84444444444443" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1651">10</tspan>
                                                        <title>10</title>
                                                    </text><text id="SvgjsText1653" font-family="Helvetica, Arial, sans-serif" x="20" y="303.8666666666667" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1654">0</tspan>
                                                        <title>0</title>
                                                    </text></g>
                                            </g>
                                            <g id="SvgjsG1494" class="apexcharts-inner apexcharts-graphical" transform="translate(39.25, 30)">
                                                <defs id="SvgjsDefs1493">
                                                    <clipPath id="gridRectMaskbq91ag8cg">
                                                        <rect id="SvgjsRect1505" width="825.75" height="276.2" x="-3" y="-3" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                    </clipPath>
                                                    <clipPath id="forecastMaskbq91ag8cg"></clipPath>
                                                    <clipPath id="nonForecastMaskbq91ag8cg"></clipPath>
                                                    <clipPath id="gridRectMarkerMaskbq91ag8cg">
                                                        <rect id="SvgjsRect1506" width="867.75" height="318.2" x="-24" y="-24" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                    </clipPath>
                                                    <linearGradient id="SvgjsLinearGradient1524" x1="0" y1="0" x2="0" y2="1">
                                                        <stop id="SvgjsStop1525" stop-opacity="0.3" stop-color="rgba(65,84,241,0.3)" offset="0"></stop>
                                                        <stop id="SvgjsStop1526" stop-opacity="0.4" stop-color="rgba(255,255,255,0.4)" offset="0.9"></stop>
                                                        <stop id="SvgjsStop1527" stop-opacity="0.4" stop-color="rgba(255,255,255,0.4)" offset="1"></stop>
                                                    </linearGradient>
                                                    <linearGradient id="SvgjsLinearGradient1546" x1="0" y1="0" x2="0" y2="1">
                                                        <stop id="SvgjsStop1547" stop-opacity="0.3" stop-color="rgba(46,202,106,0.3)" offset="0"></stop>
                                                        <stop id="SvgjsStop1548" stop-opacity="0.4" stop-color="rgba(255,255,255,0.4)" offset="0.9"></stop>
                                                        <stop id="SvgjsStop1549" stop-opacity="0.4" stop-color="rgba(255,255,255,0.4)" offset="1"></stop>
                                                    </linearGradient>
                                                    <linearGradient id="SvgjsLinearGradient1568" x1="0" y1="0" x2="0" y2="1">
                                                        <stop id="SvgjsStop1569" stop-opacity="0.3" stop-color="rgba(255,119,29,0.3)" offset="0"></stop>
                                                        <stop id="SvgjsStop1570" stop-opacity="0.4" stop-color="rgba(255,255,255,0.4)" offset="0.9"></stop>
                                                        <stop id="SvgjsStop1571" stop-opacity="0.4" stop-color="rgba(255,255,255,0.4)" offset="1"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <line id="SvgjsLine1501" x1="0" y1="0" x2="0" y2="216.5990966796875" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="216.5990966796875" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <line id="SvgjsLine1578" x1="0" y1="270.2" x2="0" y2="276.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                                <line id="SvgjsLine1579" x1="126.11538461538461" y1="270.2" x2="126.11538461538461" y2="276.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                                <line id="SvgjsLine1580" x1="252.23076923076923" y1="270.2" x2="252.23076923076923" y2="276.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                                <line id="SvgjsLine1581" x1="378.3461538461538" y1="270.2" x2="378.3461538461538" y2="276.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                                <line id="SvgjsLine1582" x1="504.46153846153845" y1="270.2" x2="504.46153846153845" y2="276.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                                <line id="SvgjsLine1583" x1="630.5769230769231" y1="270.2" x2="630.5769230769231" y2="276.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                                <line id="SvgjsLine1584" x1="756.6923076923077" y1="270.2" x2="756.6923076923077" y2="276.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                                <g id="SvgjsG1574" class="apexcharts-grid">
                                                    <g id="SvgjsG1575" class="apexcharts-gridlines-horizontal">
                                                        <line id="SvgjsLine1586" x1="0" y1="30.022222222222222" x2="819.75" y2="30.022222222222222" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1587" x1="0" y1="60.044444444444444" x2="819.75" y2="60.044444444444444" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1588" x1="0" y1="90.06666666666666" x2="819.75" y2="90.06666666666666" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1589" x1="0" y1="120.08888888888889" x2="819.75" y2="120.08888888888889" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1590" x1="0" y1="150.11111111111111" x2="819.75" y2="150.11111111111111" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1591" x1="0" y1="180.13333333333333" x2="819.75" y2="180.13333333333333" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1592" x1="0" y1="210.15555555555554" x2="819.75" y2="210.15555555555554" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1593" x1="0" y1="240.17777777777775" x2="819.75" y2="240.17777777777775" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                    </g>
                                                    <g id="SvgjsG1576" class="apexcharts-gridlines-vertical"></g>
                                                    <line id="SvgjsLine1596" x1="0" y1="270.2" x2="819.75" y2="270.2" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                    <line id="SvgjsLine1595" x1="0" y1="1" x2="0" y2="270.2" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG1577" class="apexcharts-grid-borders">
                                                    <line id="SvgjsLine1585" x1="0" y1="0" x2="819.75" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1594" x1="0" y1="270.2" x2="819.75" y2="270.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1622" x1="0" y1="270.2" x2="819.75" y2="270.2" stroke="#e0e0e0" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG1507" class="apexcharts-area-series apexcharts-plot-series">
                                                    <g id="SvgjsG1508" class="apexcharts-series" zIndex="0" seriesName="Sales" data:longestSeries="true" rel="1" data:realIndex="0">
                                                        <path id="SvgjsPath1528" d="M 0 177.1311111111111C 66.21057692307691 177.1311111111111 122.96249999999999 150.1111111111111 189.1730769230769 150.1111111111111C 233.31346153846152 150.1111111111111 271.1480769230769 186.13777777777779 315.28846153846155 186.13777777777779C 359.42884615384617 186.13777777777779 397.2634615384615 117.08666666666667 441.40384615384613 117.08666666666667C 485.54423076923075 117.08666666666667 523.3788461538461 144.10666666666665 567.5192307692307 144.10666666666665C 611.6596153846153 144.10666666666665 649.4942307692307 24.01777777777778 693.6346153846154 24.01777777777778C 737.775 24.01777777777778 775.6096153846154 102.07555555555555 819.75 102.07555555555555C 819.75 102.07555555555555 819.75 102.07555555555555 819.75 270.2 L 0 270.2z" fill="url(#SvgjsLinearGradient1524)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskbq91ag8cg)" pathTo="M 0 177.1311111111111C 66.21057692307691 177.1311111111111 122.96249999999999 150.1111111111111 189.1730769230769 150.1111111111111C 233.31346153846152 150.1111111111111 271.1480769230769 186.13777777777779 315.28846153846155 186.13777777777779C 359.42884615384617 186.13777777777779 397.2634615384615 117.08666666666667 441.40384615384613 117.08666666666667C 485.54423076923075 117.08666666666667 523.3788461538461 144.10666666666665 567.5192307692307 144.10666666666665C 611.6596153846153 144.10666666666665 649.4942307692307 24.01777777777778 693.6346153846154 24.01777777777778C 737.775 24.01777777777778 775.6096153846154 102.07555555555555 819.75 102.07555555555555C 819.75 102.07555555555555 819.75 102.07555555555555 819.75 270.2 L 0 270.2z" pathFrom="M 0 270.2 L 0 270.2 L 189.1730769230769 270.2 L 315.28846153846155 270.2 L 441.40384615384613 270.2 L 567.5192307692307 270.2 L 693.6346153846154 270.2 L 819.75 270.2 L 0 270.2"></path>
                                                        <path id="SvgjsPath1529" d="M 0 177.1311111111111C 66.21057692307691 177.1311111111111 122.96249999999999 150.1111111111111 189.1730769230769 150.1111111111111C 233.31346153846152 150.1111111111111 271.1480769230769 186.13777777777779 315.28846153846155 186.13777777777779C 359.42884615384617 186.13777777777779 397.2634615384615 117.08666666666667 441.40384615384613 117.08666666666667C 485.54423076923075 117.08666666666667 523.3788461538461 144.10666666666665 567.5192307692307 144.10666666666665C 611.6596153846153 144.10666666666665 649.4942307692307 24.01777777777778 693.6346153846154 24.01777777777778C 737.775 24.01777777777778 775.6096153846154 102.07555555555555 819.75 102.07555555555555" fill="none" fill-opacity="1" stroke="#4154f1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskbq91ag8cg)" pathTo="M 0 177.1311111111111C 66.21057692307691 177.1311111111111 122.96249999999999 150.1111111111111 189.1730769230769 150.1111111111111C 233.31346153846152 150.1111111111111 271.1480769230769 186.13777777777779 315.28846153846155 186.13777777777779C 359.42884615384617 186.13777777777779 397.2634615384615 117.08666666666667 441.40384615384613 117.08666666666667C 485.54423076923075 117.08666666666667 523.3788461538461 144.10666666666665 567.5192307692307 144.10666666666665C 611.6596153846153 144.10666666666665 649.4942307692307 24.01777777777778 693.6346153846154 24.01777777777778C 737.775 24.01777777777778 775.6096153846154 102.07555555555555 819.75 102.07555555555555" pathFrom="M 0 270.2 L 0 270.2 L 189.1730769230769 270.2 L 315.28846153846155 270.2 L 441.40384615384613 270.2 L 567.5192307692307 270.2 L 693.6346153846154 270.2 L 819.75 270.2" fill-rule="evenodd"></path>
                                                        <g id="SvgjsG1509" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0">
                                                            <g id="SvgjsG1511" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1512" r="4" cx="0" cy="177.1311111111111" class="apexcharts-marker no-pointer-events w6lpl7dgp" stroke="#ffffff" fill="#4154f1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="0" j="0" index="0" default-marker-size="4"></circle>
                                                                <circle id="SvgjsCircle1513" r="4" cx="189.1730769230769" cy="150.1111111111111" class="apexcharts-marker no-pointer-events w5mnswb68" stroke="#ffffff" fill="#4154f1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="1" j="1" index="0" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1514" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1515" r="4" cx="315.28846153846155" cy="186.13777777777779" class="apexcharts-marker no-pointer-events wppc98bmb" stroke="#ffffff" fill="#4154f1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="2" j="2" index="0" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1516" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1517" r="4" cx="441.40384615384613" cy="117.08666666666667" class="apexcharts-marker no-pointer-events wto2sjtdzk" stroke="#ffffff" fill="#4154f1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="3" j="3" index="0" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1518" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1519" r="4" cx="567.5192307692307" cy="144.10666666666665" class="apexcharts-marker no-pointer-events ws6t3tvqlf" stroke="#ffffff" fill="#4154f1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="4" j="4" index="0" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1520" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1521" r="4" cx="693.6346153846154" cy="24.01777777777778" class="apexcharts-marker no-pointer-events wzen7dd1cj" stroke="#ffffff" fill="#4154f1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="5" j="5" index="0" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1522" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1523" r="4" cx="819.75" cy="102.07555555555555" class="apexcharts-marker no-pointer-events wvymwf7h8h" stroke="#ffffff" fill="#4154f1" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="6" j="6" index="0" default-marker-size="4"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1530" class="apexcharts-series" zIndex="1" seriesName="Revenue" data:longestSeries="true" rel="2" data:realIndex="1">
                                                        <path id="SvgjsPath1550" d="M 0 237.17555555555555C 66.21057692307691 237.17555555555555 122.96249999999999 174.12888888888887 189.1730769230769 174.12888888888887C 233.31346153846152 174.12888888888887 271.1480769230769 135.1 315.28846153846155 135.1C 359.42884615384617 135.1 397.2634615384615 174.12888888888887 441.40384615384613 174.12888888888887C 485.54423076923075 174.12888888888887 523.3788461538461 168.12444444444444 567.5192307692307 168.12444444444444C 611.6596153846153 168.12444444444444 649.4942307692307 114.08444444444444 693.6346153846154 114.08444444444444C 737.775 114.08444444444444 775.6096153846154 147.10888888888888 819.75 147.10888888888888C 819.75 147.10888888888888 819.75 147.10888888888888 819.75 270.2 L 0 270.2z" fill="url(#SvgjsLinearGradient1546)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="1" clip-path="url(#gridRectMaskbq91ag8cg)" pathTo="M 0 237.17555555555555C 66.21057692307691 237.17555555555555 122.96249999999999 174.12888888888887 189.1730769230769 174.12888888888887C 233.31346153846152 174.12888888888887 271.1480769230769 135.1 315.28846153846155 135.1C 359.42884615384617 135.1 397.2634615384615 174.12888888888887 441.40384615384613 174.12888888888887C 485.54423076923075 174.12888888888887 523.3788461538461 168.12444444444444 567.5192307692307 168.12444444444444C 611.6596153846153 168.12444444444444 649.4942307692307 114.08444444444444 693.6346153846154 114.08444444444444C 737.775 114.08444444444444 775.6096153846154 147.10888888888888 819.75 147.10888888888888C 819.75 147.10888888888888 819.75 147.10888888888888 819.75 270.2 L 0 270.2z" pathFrom="M 0 270.2 L 0 270.2 L 189.1730769230769 270.2 L 315.28846153846155 270.2 L 441.40384615384613 270.2 L 567.5192307692307 270.2 L 693.6346153846154 270.2 L 819.75 270.2 L 0 270.2"></path>
                                                        <path id="SvgjsPath1551" d="M 0 237.17555555555555C 66.21057692307691 237.17555555555555 122.96249999999999 174.12888888888887 189.1730769230769 174.12888888888887C 233.31346153846152 174.12888888888887 271.1480769230769 135.1 315.28846153846155 135.1C 359.42884615384617 135.1 397.2634615384615 174.12888888888887 441.40384615384613 174.12888888888887C 485.54423076923075 174.12888888888887 523.3788461538461 168.12444444444444 567.5192307692307 168.12444444444444C 611.6596153846153 168.12444444444444 649.4942307692307 114.08444444444444 693.6346153846154 114.08444444444444C 737.775 114.08444444444444 775.6096153846154 147.10888888888888 819.75 147.10888888888888" fill="none" fill-opacity="1" stroke="#2eca6a" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="1" clip-path="url(#gridRectMaskbq91ag8cg)" pathTo="M 0 237.17555555555555C 66.21057692307691 237.17555555555555 122.96249999999999 174.12888888888887 189.1730769230769 174.12888888888887C 233.31346153846152 174.12888888888887 271.1480769230769 135.1 315.28846153846155 135.1C 359.42884615384617 135.1 397.2634615384615 174.12888888888887 441.40384615384613 174.12888888888887C 485.54423076923075 174.12888888888887 523.3788461538461 168.12444444444444 567.5192307692307 168.12444444444444C 611.6596153846153 168.12444444444444 649.4942307692307 114.08444444444444 693.6346153846154 114.08444444444444C 737.775 114.08444444444444 775.6096153846154 147.10888888888888 819.75 147.10888888888888" pathFrom="M 0 270.2 L 0 270.2 L 189.1730769230769 270.2 L 315.28846153846155 270.2 L 441.40384615384613 270.2 L 567.5192307692307 270.2 L 693.6346153846154 270.2 L 819.75 270.2" fill-rule="evenodd"></path>
                                                        <g id="SvgjsG1531" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="1">
                                                            <g id="SvgjsG1533" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1534" r="4" cx="0" cy="237.17555555555555" class="apexcharts-marker no-pointer-events w60t7bpyv" stroke="#ffffff" fill="#2eca6a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="0" j="0" index="1" default-marker-size="4"></circle>
                                                                <circle id="SvgjsCircle1535" r="4" cx="189.1730769230769" cy="174.12888888888887" class="apexcharts-marker no-pointer-events wwdp0nu6z" stroke="#ffffff" fill="#2eca6a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="1" j="1" index="1" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1536" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1537" r="4" cx="315.28846153846155" cy="135.1" class="apexcharts-marker no-pointer-events wuid05f91" stroke="#ffffff" fill="#2eca6a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="2" j="2" index="1" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1538" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1539" r="4" cx="441.40384615384613" cy="174.12888888888887" class="apexcharts-marker no-pointer-events w2ww08lrr" stroke="#ffffff" fill="#2eca6a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="3" j="3" index="1" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1540" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1541" r="4" cx="567.5192307692307" cy="168.12444444444444" class="apexcharts-marker no-pointer-events wzqt0eftd" stroke="#ffffff" fill="#2eca6a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="4" j="4" index="1" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1542" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1543" r="4" cx="693.6346153846154" cy="114.08444444444444" class="apexcharts-marker no-pointer-events wz5xnukv4" stroke="#ffffff" fill="#2eca6a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="5" j="5" index="1" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1544" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1545" r="4" cx="819.75" cy="147.10888888888888" class="apexcharts-marker no-pointer-events w2twlujb6" stroke="#ffffff" fill="#2eca6a" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="6" j="6" index="1" default-marker-size="4"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1552" class="apexcharts-series" zIndex="2" seriesName="Customers" data:longestSeries="true" rel="3" data:realIndex="2">
                                                        <path id="SvgjsPath1572" d="M 0 225.16666666666666C 66.21057692307691 225.16666666666666 122.96249999999999 237.17555555555555 189.1730769230769 237.17555555555555C 233.31346153846152 237.17555555555555 271.1480769230769 174.12888888888887 315.28846153846155 174.12888888888887C 359.42884615384617 174.12888888888887 397.2634615384615 216.16 441.40384615384613 216.16C 485.54423076923075 216.16 523.3788461538461 243.17999999999998 567.5192307692307 243.17999999999998C 611.6596153846153 243.17999999999998 649.4942307692307 198.14666666666665 693.6346153846154 198.14666666666665C 737.775 198.14666666666665 775.6096153846154 237.17555555555555 819.75 237.17555555555555C 819.75 237.17555555555555 819.75 237.17555555555555 819.75 270.2 L 0 270.2z" fill="url(#SvgjsLinearGradient1568)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="2" clip-path="url(#gridRectMaskbq91ag8cg)" pathTo="M 0 225.16666666666666C 66.21057692307691 225.16666666666666 122.96249999999999 237.17555555555555 189.1730769230769 237.17555555555555C 233.31346153846152 237.17555555555555 271.1480769230769 174.12888888888887 315.28846153846155 174.12888888888887C 359.42884615384617 174.12888888888887 397.2634615384615 216.16 441.40384615384613 216.16C 485.54423076923075 216.16 523.3788461538461 243.17999999999998 567.5192307692307 243.17999999999998C 611.6596153846153 243.17999999999998 649.4942307692307 198.14666666666665 693.6346153846154 198.14666666666665C 737.775 198.14666666666665 775.6096153846154 237.17555555555555 819.75 237.17555555555555C 819.75 237.17555555555555 819.75 237.17555555555555 819.75 270.2 L 0 270.2z" pathFrom="M 0 270.2 L 0 270.2 L 189.1730769230769 270.2 L 315.28846153846155 270.2 L 441.40384615384613 270.2 L 567.5192307692307 270.2 L 693.6346153846154 270.2 L 819.75 270.2 L 0 270.2"></path>
                                                        <path id="SvgjsPath1573" d="M 0 225.16666666666666C 66.21057692307691 225.16666666666666 122.96249999999999 237.17555555555555 189.1730769230769 237.17555555555555C 233.31346153846152 237.17555555555555 271.1480769230769 174.12888888888887 315.28846153846155 174.12888888888887C 359.42884615384617 174.12888888888887 397.2634615384615 216.16 441.40384615384613 216.16C 485.54423076923075 216.16 523.3788461538461 243.17999999999998 567.5192307692307 243.17999999999998C 611.6596153846153 243.17999999999998 649.4942307692307 198.14666666666665 693.6346153846154 198.14666666666665C 737.775 198.14666666666665 775.6096153846154 237.17555555555555 819.75 237.17555555555555" fill="none" fill-opacity="1" stroke="#ff771d" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="2" clip-path="url(#gridRectMaskbq91ag8cg)" pathTo="M 0 225.16666666666666C 66.21057692307691 225.16666666666666 122.96249999999999 237.17555555555555 189.1730769230769 237.17555555555555C 233.31346153846152 237.17555555555555 271.1480769230769 174.12888888888887 315.28846153846155 174.12888888888887C 359.42884615384617 174.12888888888887 397.2634615384615 216.16 441.40384615384613 216.16C 485.54423076923075 216.16 523.3788461538461 243.17999999999998 567.5192307692307 243.17999999999998C 611.6596153846153 243.17999999999998 649.4942307692307 198.14666666666665 693.6346153846154 198.14666666666665C 737.775 198.14666666666665 775.6096153846154 237.17555555555555 819.75 237.17555555555555" pathFrom="M 0 270.2 L 0 270.2 L 189.1730769230769 270.2 L 315.28846153846155 270.2 L 441.40384615384613 270.2 L 567.5192307692307 270.2 L 693.6346153846154 270.2 L 819.75 270.2" fill-rule="evenodd"></path>
                                                        <g id="SvgjsG1553" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="2">
                                                            <g id="SvgjsG1555" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1556" r="4" cx="0" cy="225.16666666666666" class="apexcharts-marker no-pointer-events w8wh17i08" stroke="#ffffff" fill="#ff771d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="0" j="0" index="2" default-marker-size="4"></circle>
                                                                <circle id="SvgjsCircle1557" r="4" cx="189.1730769230769" cy="237.17555555555555" class="apexcharts-marker no-pointer-events wm98j9ng6" stroke="#ffffff" fill="#ff771d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="1" j="1" index="2" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1558" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1559" r="4" cx="315.28846153846155" cy="174.12888888888887" class="apexcharts-marker no-pointer-events wx11fdr6nf" stroke="#ffffff" fill="#ff771d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="2" j="2" index="2" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1560" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1561" r="4" cx="441.40384615384613" cy="216.16" class="apexcharts-marker no-pointer-events w3v4q68km" stroke="#ffffff" fill="#ff771d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="3" j="3" index="2" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1562" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1563" r="4" cx="567.5192307692307" cy="243.17999999999998" class="apexcharts-marker no-pointer-events wkh45rooeg" stroke="#ffffff" fill="#ff771d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="4" j="4" index="2" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1564" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1565" r="4" cx="693.6346153846154" cy="198.14666666666665" class="apexcharts-marker no-pointer-events wtlmrg8cl" stroke="#ffffff" fill="#ff771d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="5" j="5" index="2" default-marker-size="4"></circle>
                                                            </g>
                                                            <g id="SvgjsG1566" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskbq91ag8cg)">
                                                                <circle id="SvgjsCircle1567" r="4" cx="819.75" cy="237.17555555555555" class="apexcharts-marker no-pointer-events wrq498bwf" stroke="#ffffff" fill="#ff771d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" rel="6" j="6" index="2" default-marker-size="4"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1510" class="apexcharts-datalabels" data:realIndex="0"></g>
                                                    <g id="SvgjsG1532" class="apexcharts-datalabels" data:realIndex="1"></g>
                                                    <g id="SvgjsG1554" class="apexcharts-datalabels" data:realIndex="2"></g>
                                                </g>
                                                <line id="SvgjsLine1597" x1="0" y1="0" x2="819.75" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                                <line id="SvgjsLine1598" x1="0" y1="0" x2="819.75" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                                <g id="SvgjsG1599" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                    <g id="SvgjsG1600" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText1602" font-family="Helvetica, Arial, sans-serif" x="0" y="298.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                            <tspan id="SvgjsTspan1603">00:00</tspan>
                                                            <title>00:00</title>
                                                        </text><text id="SvgjsText1605" font-family="Helvetica, Arial, sans-serif" x="126.11538461538461" y="298.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                            <tspan id="SvgjsTspan1606">01:00</tspan>
                                                            <title>01:00</title>
                                                        </text><text id="SvgjsText1608" font-family="Helvetica, Arial, sans-serif" x="252.23076923076923" y="298.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                            <tspan id="SvgjsTspan1609">02:00</tspan>
                                                            <title>02:00</title>
                                                        </text><text id="SvgjsText1611" font-family="Helvetica, Arial, sans-serif" x="378.3461538461538" y="298.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                            <tspan id="SvgjsTspan1612">03:00</tspan>
                                                            <title>03:00</title>
                                                        </text><text id="SvgjsText1614" font-family="Helvetica, Arial, sans-serif" x="504.46153846153845" y="298.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                            <tspan id="SvgjsTspan1615">04:00</tspan>
                                                            <title>04:00</title>
                                                        </text><text id="SvgjsText1617" font-family="Helvetica, Arial, sans-serif" x="630.5769230769231" y="298.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                            <tspan id="SvgjsTspan1618">05:00</tspan>
                                                            <title>05:00</title>
                                                        </text><text id="SvgjsText1620" font-family="Helvetica, Arial, sans-serif" x="756.6923076923077" y="298.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                            <tspan id="SvgjsTspan1621">06:00</tspan>
                                                            <title>06:00</title>
                                                        </text></g>
                                                </g>
                                                <g id="SvgjsG1655" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG1656" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG1657" class="apexcharts-point-annotations"></g>
                                                <rect id="SvgjsRect1658" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect>
                                                <rect id="SvgjsRect1659" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect>
                                            </g>
                                        </svg>
                                        <div class="apexcharts-tooltip apexcharts-theme-light">
                                            <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                            <div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(65, 84, 241);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                    <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                    <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                    <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                            </div>
                                            <div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(46, 202, 106);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                    <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                    <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                    <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                            </div>
                                            <div class="apexcharts-tooltip-series-group" style="order: 3;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 119, 29);"></span>
                                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                    <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div>
                                                    <div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div>
                                                    <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light">
                                            <div class="apexcharts-xaxistooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                        </div>
                                        <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                            <div class="apexcharts-yaxistooltip-text"></div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#reportsChart"), {
                                            series: [{
                                                name: 'Sales',
                                                data: [31, 40, 28, 51, 42, 82, 56],
                                            }, {
                                                name: 'Revenue',
                                                data: [11, 32, 45, 32, 34, 52, 41]
                                            }, {
                                                name: 'Customers',
                                                data: [15, 11, 32, 18, 9, 24, 11]
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'area',
                                                toolbar: {
                                                    show: false
                                                },
                                            },
                                            markers: {
                                                size: 4
                                            },
                                            colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                    shadeIntensity: 1,
                                                    opacityFrom: 0.3,
                                                    opacityTo: 0.4,
                                                    stops: [0, 90, 100]
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                curve: 'smooth',
                                                width: 2
                                            },
                                            xaxis: {
                                                type: 'datetime',
                                                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                                            },
                                            tooltip: {
                                                x: {
                                                    format: 'dd/MM/yy HH:mm'
                                                },
                                            }
                                        }).render();
                                    });
                                </script>
                                <!-- End Line Chart -->

                            </div>

                        </div>
                    </div><!-- End Reports -->

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><a href="#">#2457</a></th>
                                            <td>Brandon Jacob</td>
                                            <td><a href="#" class="text-primary">At praesentium minu</a></td>
                                            <td>$64</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2147</a></th>
                                            <td>Bridie Kessler</td>
                                            <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                                            <td>$47</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2049</a></th>
                                            <td>Ashleigh Langosh</td>
                                            <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                                            <td>$147</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2644</a></th>
                                            <td>Angus Grady</td>
                                            <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                                            <td>$67</td>
                                            <td><span class="badge bg-danger">Rejected</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2644</a></th>
                                            <td>Raheem Lehner</td>
                                            <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                                            <td>$165</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->

                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">Top Selling <span>| Today</span></h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Preview</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Sold</th>
                                            <th scope="col">Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                                            <td>$64</td>
                                            <td class="fw-bold">124</td>
                                            <td>$5,828</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img src="assets/img/product-2.jpg" alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                                            <td>$46</td>
                                            <td class="fw-bold">98</td>
                                            <td>$4,508</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img src="assets/img/product-3.jpg" alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                                            <td>$59</td>
                                            <td class="fw-bold">74</td>
                                            <td>$4,366</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img src="assets/img/product-4.jpg" alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                                            <td>$32</td>
                                            <td class="fw-bold">63</td>
                                            <td>$2,016</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img src="assets/img/product-5.jpg" alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                                            <td>$79</td>
                                            <td class="fw-bold">41</td>
                                            <td>$3,239</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->

                </div>
            </div>

        </div>
    </section>
</main>
@endsection