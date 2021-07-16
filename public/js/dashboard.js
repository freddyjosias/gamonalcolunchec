$(document).ready(function() {

    let baseURL = 'http://localhost/licorlandsorftware/';

    $('#dataTableDash').DataTable();
    $('#dataTable_impr_minstock').DataTable({
        "paging": false,
        "bFilter": false
    });

    $.ajax({
        url: baseURL + '/reportes/getjsoncomprasventas',
        type : 'GET',
        async: true,
        dataType : 'json',
        success:function (resp) {
            
            if (resp == 0) 
            { 
            }
            else
            {
                //var resp = JSON.parse(resp);

                anychart.onDocumentReady(function () {
                    // create data set on our data,also we can pud data directly to series
                    var dataSet = anychart.data.set(resp);
            
                    // map data for the first series,take value from first column of data set
                    var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });
            
                    // map data for the second series,take value from second column of data set
                    var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });
            
                    // map data for the third series, take x from the zero column and value from the third column of data set
                    //var thirdSeriesData = dataSet.mapAs({ x: 0, value: 3 });
            
                    // create line chart
                    var chart = anychart.line();
            
                    // turn on chart animation
                    chart.animation(true);
            
                    // turn on the crosshair and tune it
                    chart
                        .crosshair()
                        .enabled(true)
                        .yLabel(false)
                        .xLabel(false)
                        .yStroke(null);
            
                    // set chart padding
                    chart.padding([10, 20, 5, 20]);
            
                    // set chart title text settings
                    chart.title('Cantidad de Ventas y Compras');
            
                    // set yAxis title
                    chart.yAxis().title('Cantidad');
            
                    // temp variable to store series instance
                    var series;
            
                    // setup first series
                    series = chart.line(firstSeriesData);
                    series.name('Ventas').stroke('#000000').size(4);
                    series.hovered().markers(true);
            
                    // setup second series
                    series = chart.line(secondSeriesData);
                    series.name('Compras').size(4).stroke({
                        color: '#6C6C6C',
                        dash: '3 5 10 5'
                    });
                    series.hovered().markers(true);
            
                    /* // setup third series
                    series = chart.line(thirdSeriesData);
                    series.name('Order Cancellation').size(4).stroke({
                        color: '#C8C8C8',
                        dash: '3 5'
                    });
                    series.hovered().markers(true); */
            
                    // interactivity and tooltip settings
                    chart.interactivity().hoverMode('by-x');
            
                    chart
                        .tooltip()
                        .displayMode('separated')
                        .positionMode('point')
                        .separator(false)
                        .position('right')
                        .anchor('left-bottom')
                        .offsetX(2)
                        .offsetY(5)
                        .title(false)
                        .format('{%Value}');
            
                    // turn the legend on
                    chart.legend(true);
            
                    // set container id for the chart
                    chart.container('cont_ventas');
                    // initiate chart drawing
                    chart.draw();
                });
            }
        }
    });

    $.ajax({
        url: baseURL + '/reportes/getjsoncomprasventasprecio',
        type : 'GET',
        async: true,
        dataType : 'json',
        success:function (resp) {
            
            if (resp == 0) 
            { 
            }
            else
            {
                console.log(resp);

                anychart.onDocumentReady(function () {
                    
                    var dataSet = anychart.data.set(resp);
            
                    var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });
            
                    var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });
            
                    var chart = anychart.line();
            
                    chart.animation(true);
            
                    chart
                        .crosshair()
                        .enabled(true)
                        .yLabel(false)
                        .xLabel(false)
                        .yStroke(null);
            
                    // set chart padding
                    chart.padding([10, 20, 5, 20]);
            
                    chart.title('Ingresos y Egresos (Compra y Venta)');
            
                    chart.yAxis().title('Precio (S/)');
            
                    var series;
            
                    series = chart.line(firstSeriesData);
                    series.name('Ventas').stroke('#000000').size(4);
                    series.hovered().markers(true);
            
                    series = chart.line(secondSeriesData);
                    series.name('Compras').size(4).stroke({
                        color: '#6C6C6C',
                        dash: '3 5 10 5'
                    });
                    series.hovered().markers(true);

                    chart.interactivity().hoverMode('by-x');
            
                    chart
                        .tooltip()
                        .displayMode('separated')
                        .positionMode('point')
                        .separator(false)
                        .position('right')
                        .anchor('left-bottom')
                        .offsetX(2)
                        .offsetY(5)
                        .title(false)
                        .format('S/ {%Value}');
            
                    chart.legend(true);
            
                    chart.container('cont_ventas_soles');
                    chart.draw();
                });
            }
        }
    });

    $('#print_table_minstock').click(function () {

        let newWin = window.open('http://localhost/licorlandsorftware/dashboard/imprtableminstock','Print-Window');

        //newWin.document.open();

        //newWin.document.close();

        setTimeout(function(){newWin.close();},100);

    });

    $('#print_table_cliente_rec').click(function () {

        let newWin = window.open('http://localhost/licorlandsorftware/dashboard/imprtableclientesrec','Print-Window');

        //newWin.document.open();

        //newWin.document.close();

        setTimeout(function(){newWin.close();},100);

    });
    
});