<?php
ob_start();
require_once "../../config/konekcija.php";
include "../users/functions.php";

    $users = get_all_users();
    $excelApp = new COM("Excel.Application");
    $excelApp->Visible = 1;
    // $excel_file->DisplayAlerts = 1;
    $excel_file=$excelApp->Workbooks->Add();
    $worksheet=$excel_file->Worksheets("Sheet1");
        $rb = 1;
        foreach($users as $u){
            $field = $worksheet->Range("A{$rb}");
            $field->activate;
            $field->Value = $u->name;
            $field = $worksheet->Range("B{$rb}");
            $field->activate;
            $field->Value = $u->surname;
            $field = $worksheet->Range("C{$rb}");
            $field->activate;
            $field->Value = $u->username;
            $field = $worksheet->Range("D{$rb}");
            $field->activate;
            $field->Value = $u->email;
            $field = $worksheet->Range("E{$rb}");
            $field->activate;
            $field->Value = $u->role;
            $rb++;
        }

    // $field = $sheet->Range("F1");
    // $field->activate;
    // $field->value = $br-1;
    // $workbook->SaveAs(BASE_PATH."models/files/users.xlsx",-4143);
    // $workbook->Save();
    // $workbook->Saved=true;
    // $workbook->Close;
    // $excel_file->Workbooks->Close();
    // $excel_file->Quit();

// unset($sheet);
// unset($workbook);
// unset($excel_file);

$excel_file->_SaveAs("Users".time().".xlsx");
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="users.xlsx"');
ob_get_clean();
// readfile($$excel_file);
header( "Content-Type: application/vnd.ms-excel" );
header( "Content-disposition: attachment; filename=users.xls" );

header("Location:../../views/pages/admin.php?page=users");