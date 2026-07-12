<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Salary Slip</title>

<style>

@page {
    margin: 25px;
}


body {

    font-family: DejaVu Sans, sans-serif;
    color:#1f2937;
    font-size:13px;

}


/* HEADER */

.header {

    width:100%;
    border-bottom:3px solid #1e40af;
    padding-bottom:15px;
    margin-bottom:20px;

}


.logo {

    width:70px;
    height:70px;
    background:#1e40af;
    color:white;
    font-size:26px;
    font-weight:bold;
    text-align:center;
    line-height:70px;
    border-radius:10px;

}


.company-name {

    font-size:22px;
    font-weight:bold;
    color:#1e40af;

}


.company-info {

    color:#64748b;
    line-height:20px;

}


.title-box {

    background:#1e40af;
    color:white;
    padding:14px;
    text-align:center;
    font-size:20px;
    font-weight:bold;
    margin-bottom:25px;

}


/* SECTION */

.section {

    margin-bottom:20px;

}


.section-title {

    background:#eff6ff;
    color:#1e40af;
    font-weight:bold;
    padding:8px 12px;
    border-left:5px solid #1e40af;
    margin-bottom:8px;

}



.info-table {

    width:100%;
    border-collapse:collapse;

}


.info-table td {

    border-bottom:1px solid #e5e7eb;
    padding:9px;

}


.label {

    width:35%;
    font-weight:bold;
    color:#475569;

}


/* SALARY */


.salary {

    width:100%;
    border-collapse:collapse;

}


.salary th {

    background:#1e40af;
    color:white;
    padding:10px;
    text-align:left;

}


.salary td {

    border-bottom:1px solid #e5e7eb;
    padding:10px;

}



.amount {

    text-align:right;

}



.total {

    background:#dcfce7;
    color:#166534;
    font-size:18px;
    font-weight:bold;

}




/* FOOTER */


.signatures {

    margin-top:60px;
    width:100%;
    text-align:center;

}


.sign {

    height:70px;
    border:1px dashed #94a3b8;
    padding-top:15px;

}


.footer {

    margin-top:30px;
    text-align:center;
    color:#94a3b8;
    font-size:11px;

}


</style>

</head>


<body>



<!-- COMPANY -->

<table class="header">

<tr>

<td width="20%">

<div class="logo">
ERP
</div>

</td>


<td>

<div class="company-name">
ERP Solutions Company
</div>


<div class="company-info">

TARTUS - STREET4568<br>

Phone: +963 933 555 333<br>

Email: info@erp.com

</div>


</td>


</tr>

</table>




<div class="title-box">

EMPLOYEE SALARY SLIP

</div>






<!-- EMPLOYEE -->


<div class="section">

<div class="section-title">
Employee Information
</div>


<table class="info-table">


<tr>

<td class="label">
Employee No
</td>

<td>
{{ $payroll->employee->employee_no }}
</td>

</tr>



<tr>

<td class="label">
Employee Name
</td>

<td>

{{ $payroll->employee->first_name }}
{{ $payroll->employee->last_name }}

</td>

</tr>



<tr>

<td class="label">
Department
</td>

<td>

{{ $payroll->employee->department->name ?? '-' }}

</td>

</tr>



<tr>

<td class="label">
Payroll Period
</td>

<td>

{{ $payroll->month }}/{{ $payroll->year }}

</td>

</tr>


</table>

</div>







<!-- ATTENDANCE -->


<div class="section">


<div class="section-title">

Attendance Summary

</div>


<table class="info-table">


<tr>

<td class="label">
Present Days
</td>

<td>
{{ $payroll->present_days }}
</td>

</tr>


<tr>

<td class="label">
Absent Days
</td>

<td>
{{ $payroll->absent_days }}
</td>

</tr>


<tr>

<td class="label">
Daily Rate
</td>

<td>

{{ number_format($payroll->daily_rate,2) }}

</td>

</tr>


</table>


</div>







<!-- SALARY -->


<div class="section">


<div class="section-title">

Salary Details

</div>


<table class="salary">


<tr>

<th>
Description
</th>


<th>
Amount
</th>

</tr>



<tr>

<td>
Basic Salary
</td>

<td class="amount">

{{ number_format($payroll->basic_salary,2) }}

</td>

</tr>



<tr>

<td>
Gross Salary
</td>

<td class="amount">

{{ number_format($payroll->gross_salary,2) }}

</td>

</tr>




<tr>

<td>
Overtime
</td>

<td class="amount">

{{ number_format($payroll->overtime_amount ?? 0,2) }}

</td>

</tr>




<tr>

<td>
Bonuses
</td>

<td class="amount">

{{ number_format($payroll->bonus_amount ?? 0,2) }}

</td>

</tr>



<tr>

<td>
Advances
</td>

<td class="amount">

- {{ number_format($payroll->advance_deduction ?? 0,2) }}

</td>

</tr>




<tr>

<td>
Loans
</td>

<td class="amount">

- {{ number_format($payroll->loan_deduction ?? 0,2) }}

</td>

</tr>



<tr>

<td>
Deductions
</td>

<td class="amount">

- {{ number_format($payroll->deductions ?? 0,2) }}

</td>

</tr>



<tr class="total">


<td>
NET SALARY
</td>


<td class="amount">

{{ number_format($payroll->net_salary,2) }}

</td>


</tr>


</table>


</div>







<!-- SIGNATURE -->


<table class="signatures">


<tr>


<td>

<div class="sign">

Employee Signature

</div>

</td>



<td>

<div class="sign">

HR Manager

</div>

</td>



<td>

<div class="sign">

Finance

</div>

</td>



</tr>


</table>





<div class="footer">

Generated electronically by ERP System 
     

</div>



</body>

</html>