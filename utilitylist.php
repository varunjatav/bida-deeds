<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIDA LAMS</title>
    <link href="css/stylus.css" rel="stylesheet" type="text/css">
    <link href="css/common_master.css" rel="stylesheet" type="text/css">
    <link href="css/font.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style.css">
    <script src="scripts/jquery.min.js"></script>

    <style>
        .table-head {
            background: #f4f4f4;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-weight: 500;
            font-size: 13px;
        }
        a{
            font-weight: 600;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="table-wrap">
        <div class="table-head liquidcells">
            <div class="left tbl-cell size-xxl text-wrapping" title="UTILITY NAME"><b>UTILITY NAME</b></div>
            <div class="clr"></div>
        </div>
        <div class="table-head liquidcells">
            <div class="left tbl-cell size-xxl text-wrapping" title="Clear User Logs">Check error logs (OPEN)</div>
            <div class="tbl-cell size-xxl text-wrapping ordr-excn left" title="">
                <a href="utility/check_error_logs">Go to URL</a>
            </div>
            <div class="clr"></div>
        </div>

        <div class="table-head liquidcells">
            <div class="left tbl-cell size-xxl text-wrapping" title="Clear User Logs">Clear error logs (RESTRICTED)</div>
            <div class="tbl-cell size-xxl text-wrapping ordr-excn left" title="">
                <a href="utility/remove_error_logs?password=123456">Go to URL</a>
            </div>
            <div class="clr"></div>
        </div>

        <div class="table-head liquidcells">
            <div class="left tbl-cell size-xxl text-wrapping" title="Export Full Database">Export Full Database (OPEN)</div>
            <div class="tbl-cell size-l text-wrapping ordr-excn left" title="">
                <a target="_blank" href="utility/export_all">Go to URL</a>
            </div>
            <div class="clr"></div>
        </div>

        <div class="table-head liquidcells">
            <div class="left tbl-cell size-xxl text-wrapping" title="Export Data">Export Table Database (OPEN)</div>
            <div class="tbl-cell size-l text-wrapping ordr-excn left" title="">
                <a target="_blank" href="utility/export?tables=">Go to URL</a>
            </div>
            <div class="clr"></div>
        </div>
        <div class="table-head liquidcells">
            <div class="left tbl-cell size-xxl text-wrapping" title="Update Dimension No">Update Dimension No (OPEN)</div>
            <div class="tbl-cell size-l text-wrapping ordr-excn left" title="">
                <a target="_blank" href="utility/update_dimension_no">Go to URL</a>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</body>
</html>