<?php
include_once("connection_sql.php");

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    $sql = "SELECT STK_NO, DESCRIPT, GROUP2  FROM `s_mas` where GROUP1 != 'PRE_INK'";
    foreach ($conn->query($sql) as $row) {
        $bulkInsert[] = "('01', '" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["GROUP2"] . "',0)";
        $bulkInsert[] = "('02', '" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["GROUP2"] . "',0)";
    }
    if (count($bulkInsert) > 0) {
        $sql = "insert into s_submas (STO_CODE, STK_NO, DESCRIPt, dev_type, QTYINHAND) values " . implode(',', $bulkInsert);
        $conn->exec($sql);
    }

    $conn->commit();
    echo "Saved";
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
?>