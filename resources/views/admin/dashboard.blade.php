@extends('admin.layout')
@section('content')
<style>
#chartdiv {
      width: 100%;
      height: 400px;
    }

#pieChartdiv {
    width: 100%;
    height: 300px;
    direction: rtl;
    margin-top:44px;
  }

 </style>
<main>
    <!-- Main page content-->
 <div class="container-xl px-4 mt-n10" style="margin-top:5%;">
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="card h-100 dashboardCard">
                <a class=" stretched-link" href="{{url('/controlMainPage')}}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="large fw-bold">صفحه اصلی</div>
                                <div class="text-xxl fw-bold"></div>
                            </div>
                                <i class="fa fa-home fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <div class=""><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path>
                        </svg>
                      </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card  h-100 dashboardCard">
                <a class=" stretched-link" @if(hasPermission(Session::get( 'adminId'),'karbaranN' ) > -1) href="{{url('/listKarbaran')}}" @else href="#" @endif>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="fw-bold">کاربران</div>
                                <div class="text-lg fw-bold"></div>
                            </div>
                               <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                          </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <div class=""><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 dashboardCard">
                <a class=" stretched-link"  @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) > -1) href="{{url('/controlMainPage')}}" @else href="#" @endif>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="-75 fw-bold">مدیریت اختصاصی سایت</div>
                                <div class="text-lg fw-bold"></div>
                            </div>
                              <i class="fa fa-cog fa-3x" aria-hidden="true"></i>
                          </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <div class=""><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 dashboardCard">
                <a class=" stretched-link"   @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) > -1) href="{{url('/webReports')}}" @else href="#" @endif>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="-75 fw-bold ">گزارشات</div>
                                <div class="text-lg fw-bold"></div>
                            </div>
                            <i class="fa-solid fa-chart-mixed fa-3x"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <div class=""><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
<br>
<br>
        <div class="row">
            <div class="col-md-3">
                <div class="card h-100 dashboardCard">
                  <a class=" stretched-link" href="{{url('/controlMainPage')}}" target="_blank">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="fw-bold">مدیریت معلومات و قوانین سایت</div>
                                <div class="text-lg fw-bold"></div>
                            </div>
                            <i class="fa fa-book fa-3x" aria-hidden="true"></i>
                            </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                       <div class=""><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 dashboardCard">
                  <a class="stretched-link" href="{{url('/loginCrm')}}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="-75 fw-bold"> سیستم مدیریت مشتری (CRM)  </div>
                                <div class="text-lg fw-bold"></div>
                            </div>
                            <i class="fa fa-group fa-3x" aria-hidden="true"></i>
                            </div>
                     </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                       <div class=""><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 dashboardCard">
                  <a class="stretched-link" href="" target="_blank">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="-75 fw-bold">سایت قبلی </div>
                                <div class="text-lg fw-bold"></div>
                            </div>
                            <i class="fa fa-globe fa-3x" aria-hidden="true"></i>
                            </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                       <div class=""><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
            </div>
        </div>

    </div>

    <!-- <div class="container">
    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div id="pieChartdiv"></div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
              <div id="chartdiv"></div>
            </div>
         </div>
       </div>
       </div>
    </div> -->

    <!-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="//cdn.amcharts.com/lib/5/percent.js"></script> -->
    <!-- Chart code -->
<!-- <script>

    am5.ready(function() {
    // Create root element
    var root = am5.Root.new("chartdiv");
    root._logo.dispose();
    // Set themes
    root.setThemes([
      am5themes_Animated.new(root)
    ]);

    // Create chart
    var chart = root.container.children.push(
      am5xy.XYChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "none",
        wheelY: "none",

      })
    );

    // Add cursor
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineY.set("visible", false);
    // Create axes
    var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
    xRenderer.labels.template.setAll({ text: "{realName}" });
    var xAxis = chart.xAxes.push(
      am5xy.CategoryAxis.new(root, {
        maxDeviation: 0,
        categoryField: "category",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root, {
        labelText: "{realName}"
        })
      })
    );

    var yAxis = chart.yAxes.push(
      am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root, {})
      })
    );

    var yAxis2 = chart.yAxes.push(
      am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        syncWithAxis: yAxis,
        renderer: am5xy.AxisRendererY.new(root, { opposite: true })
      })
    );

    // Create series
    var series = chart.series.push(
      am5xy.ColumnSeries.new(root, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis2,
        valueYField: "value",
        sequencedInterpolation: true,
        categoryXField: "category",
        tooltip: am5.Tooltip.new(root, {
        labelText: "{provider} {realName}: {valueY}"
        })
      })
    );

    series.columns.template.setAll({
      fillOpacity: 0.9,
      strokeOpacity: 0
    });

    series.columns.template.adapters.add("fill", (fill, target) => {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });

    series.columns.template.adapters.add("stroke", (stroke, target) => {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });

    var lineSeries = chart.series.push(
        am5xy.LineSeries.new(root, {
        name: "Series 2",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "quantity",
        sequencedInterpolation: true,
        stroke: chart.get("colors").getIndex(13),
        fill: chart.get("colors").getIndex(13),
        categoryXField: "category",
        tooltip: am5.Tooltip.new(root, {
        labelText: "{valueY}"
        })
      })
    );

    lineSeries.strokes.template.set("strokeWidth", 2);

    lineSeries.bullets.push(function () {
      return am5.Bullet.new(root, {
        locationY: 1,
        locationX: undefined,
        sprite: am5.Circle.new(root, {
          radius: 5,
          fill: lineSeries.get("fill")
        })
      });
    });

    // when data validated, adjust location of data item based on count
    lineSeries.events.on("datavalidated", function () {
      am5.array.each(lineSeries.dataItems, function (dataItem) {
        // if count divides by two, location is 0 (on the grid)
        if (
          dataItem.dataContext.count / 2 ==
          Math.round(dataItem.dataContext.count / 2)
        ) {
          dataItem.set("locationX", 0);
        }
        // otherwise location is 0.5 (middle)
        else {
          dataItem.set("locationX", 0.5);
        }
      });
    });

    var chartData = [];

    // Set data
    var data = {
      "انبار 4": {
        "برنج ها ": 10,
        "روغن ها": 35,
        "حبوبات": 5,
        " خشکبار": 20,
        quantity: 430
      },
      "انبار 3": {
        "کنسروجات": 15,
        "ادویه جات": 21,
        quantity: 210
      },
      "انبار 2": {
        "محصولات تک نفره": 25,
        "مکارونی ": 11,
        quantity: 265
      },
      "انبار 1": {
        "چای": 12,
        "نوشیدنی ها": 15,
        quantity: 98
      }
    };

    // process data ant prepare it for the chart
    for (var providerName in data) {
      var providerData = data[providerName];

      // add data of one provider to temp array
      var tempArray = [];
      var count = 0;
      // add items
      for (var itemName in providerData) {
        if (itemName != "quantity") {
          count++;
          // we generate unique category for each column (providerName + "_" + itemName) and store realName
          tempArray.push({
            category: providerName + "_" + itemName,
            realName: itemName,
            value: providerData[itemName],
            provider: providerName
          });
        }
      }
      // sort temp array
      tempArray.sort(function (a, b) {
        if (a.value > b.value) {
          return 1;
        } else if (a.value < b.value) {
          return -1;
        } else {
          return 0;
        }
      });

      // add quantity and count to middle data item (line series uses it)
      var lineSeriesDataIndex = Math.floor(count / 2);
      tempArray[lineSeriesDataIndex].quantity = providerData.quantity;
      tempArray[lineSeriesDataIndex].count = count;
      // push to the final data
      am5.array.each(tempArray, function (item) {
        chartData.push(item);
      });

      // create range (the additional label at the bottom)

      var range = xAxis.makeDataItem({});
      xAxis.createAxisRange(range);

      range.set("category", tempArray[0].category);
      range.set("endCategory", tempArray[tempArray.length - 1].category);

      var label = range.get("label");

      label.setAll({
        text: tempArray[0].provider,
        dy: 30,
        fontWeight: "bold",
        fontSize: 14,
        // tooltipText: tempArray[0].provider,
        // rtl:true
      });

      var tick = range.get("tick");
      tick.setAll({ visible: true, strokeOpacity: 1, length: 50, location: 0 });

      var grid = range.get("grid");
      grid.setAll({ strokeOpacity: 1 });
    }

    // add range for the last grid
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("category", chartData[chartData.length - 1].category);
    var tick = range.get("tick");
    tick.setAll({ visible: true, strokeOpacity: 1, length: 50, location: 1 });

    var grid = range.get("grid");
    grid.setAll({ strokeOpacity: 1, location: 1 });

    xAxis.data.setAll(chartData);
    series.data.setAll(chartData);
    lineSeries.data.setAll(chartData);

    // Make stuff animate on load
    series.appear(1000);
    chart.appear(1000, 100);

    }); // end am5.ready()
    </script>
<script> -->

 <!-- Create root and chart -->
<!-- var root = am5.Root.new("pieChartdiv");
root._logo.dispose();

root.setThemes([
  am5themes_Animated.new(root)
]);

var chart = root.container.children.push(
  am5percent.PieChart.new(root, {})
);

// Define data
var chartData = [];
var data = [{
  anbar: "انبار 1",
  sales: 100000,
}, {
  anbar: "انبار 2",
  sales: 60000
}, {
  anbar: "انبار 3",
  sales: 80000
}, {
  anbar: "انبار 4",
  sales: 68000
}];

// Create series
var series = chart.series.push(
  am5percent.PieSeries.new(root, {
    name: "Series",
    valueField: "sales",
    categoryField: "anbar",
    alignLabels: false,

  })
);

series.data.setAll(data);
series.labels.template.setAll({
  fontSize: 12,
  align:'center',
  text: "{category}",
  textType: "circular",
  inside: true,
  radius: 10,
  fill: am5.color(0xffffff),
  rtl:true
})

</script> -->
</main>

@endsection
