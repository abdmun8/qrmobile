<?php

if (isset($_GET['log'])):
    $data       = [];
    $mysql_conn = new PDO("mysql:host=localhost;dbname=sgedb", 'root', 's3k4w4n');
    $sql        = "SELECT * FROM import_dbf_log where timestamp >= date_sub(NOW(), INTERVAL 1 DAY) order by `id` DESC";
    $stmt       = $mysql_conn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['data' => $res]);
    } else {
        echo json_encode(['data' => $data]);
    } else :
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>QR Mobile</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css'>
    </head>

    <body style="padding:1%;">
        <table id="log-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Timestamp</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                getlog();
            });

            function getlog() {
                if ($.fn.dataTable.isDataTable('#log-table')) {
                    tableIncoming = $('#log-table').DataTable();
                } else {
                    tableIncoming = $('#log-table').DataTable({
                        "ajax": '?log=1',
                        "columns": [
                            {
                                "data": 'id'
                            },
                            {
                                "data": "timestamp"
                            },
                            {
                                "data": "msg"
                            },
                        ],
                        "ordering": true,
                        "deferRender": true,
                        "pageLength": 100,
                        "order": [
                            [0, "desc"]
                        ],
                        "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }],
                        "fnDrawCallback": function(oSettings) {
                            // utilsBidang();
                        }
                    });
                }
            }
        </script>
    </body>

    </html>
<?php endif;?>