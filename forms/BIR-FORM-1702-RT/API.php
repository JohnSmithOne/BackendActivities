<?php
use setasign\Fpdi\Fpdi;
// or for usage with TCPDF:
// use setasign\Fpdi\Tcpdf\Fpdi;

// or for usage with tFPDF:
// use setasign\Fpdi\Tfpdf\Fpdi;

// setup the autoload function
require_once('vendor/autoload.php');

// initiate FPDI
$pdf = new Fpdi();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile("BIR-FORM-1702-RT.pdf");
// import page 1
$tplId = $pdf->importPage(1);
// use the imported page and place it at point 15,10 with a width of 195 mm
$pdf->useTemplate($tplId, 7, 2, 195);


//////////
//Header//
/////////

    // Add text to the PDF
    $pdf->SetFont('Arial', '', 12);

    // 1 For Calendar or Fiscal
    $pdf->SetXY(23, 34.6);
    $pdf->Write(21, '/');

    // 2 Year Ended
    $pdf->SetXY(18, 42.7);
    $pdf->Write(20, '0 3        2 3');

    // 3 Amended Return?
    $pdf->SetXY(58.6, 39.7);
    $pdf->Write(21, '/');

    // 4 Short Period Return?
    $pdf->SetXY(88.6, 39.7);
    $pdf->Write(21, '/');

    // 5 Alphanumeric Tax Code(ATC)
    $pdf->SetFont('Arial', '', 7.6);
    $pdf->SetXY(120, 41);
    $pdf->Write(21, ' IC 021          General Professional Partnership');


//Set font back to 12
$pdf->SetFont('Arial', '', 12);


///////////////////////////////////
//Part 1 - Background Information//
///////////////////////////////////

    // 6 Taxpayer Identification Number (TIN)
    $pdf->SetXY(76.3, 52.8);
    $pdf->Write(21, '1  2  3      4  5  6       7  8  9 ');

    // 7 RDO
    $pdf->SetXY(177.7, 52.8);
    $pdf->Write(21, '1  2  3 ');

    // 8 Registered Name
    $pdf->SetXY(13, 62.8);
    $pdf->Write(21, 'C  I  E  L  O      J  O H  N     R  E G  A  L  A D  O     B  A  R  E Z  A ');

    // 9 Registered Address
    $pdf->SetXY(13, 84.8);
    $pdf->Write(21, 'B  R G Y      S  A N      G  R E G  O R  I   O     S  A  N  P A  B L  O  C  I  T  Y   L  A G U  N  A ');

    // 9 ZIP Code
    $pdf->SetXY(177.3, 96.7);
    $pdf->Write(21, '4  0  0  0');

    // 10 Date of Incorporation/Organization
    $pdf->SetXY(66, 102);
    $pdf->Write(21, '0  1      2  5       2  0  2  3 ');

    // 11 Contact Number
    $pdf->SetXY(144, 102.5);
    $pdf->Write(21, '0  9  0  8  3  0  3  6  1  0  1');

    // 12 Email Address
    $pdf->SetXY(42, 109);
    $pdf->Write(21, 'b  a   r  e  z  a   c   i  e   l  o   j   o  h  n  @ g m  a   i   l   .   c  o  m');

    // 13 Method of Deductions
    $pdf->SetXY(50.6, 114.7);
    $pdf->Write(21, '/');

///////////////////////////////
//Part II – Total Tax Payable//
///////////////////////////////

    // 14 Tax Due
    $pdf->SetXY(182, 127);
    $pdf->Write(21, '0  0  0');

    // 15 Less: Total Tax Credits/Payments
    $pdf->SetXY(182, 133);
    $pdf->Write(21, '0  0  0');
    
    // 16 Net Tax Payable / (Overpayment)
    $pdf->SetXY(182, 139);
    $pdf->Write(21, '0  0  0');

    // 17 Surcharge
    $pdf->SetXY(182, 149);
    $pdf->Write(21, '0  0  0');

    // 18 Interest
    $pdf->SetXY(182, 155);
    $pdf->Write(21, '0  0  0');

    // 19 Compromise
    $pdf->SetXY(182, 161);
    $pdf->Write(21, '0  0  0');

    // 20 Total Penalties (Sum of Items 17 to 19)
    $pdf->SetXY(182, 167);
    $pdf->Write(21, '0  0  0');

    // 21 TOTAL AMOUNT PAYABLE / (Overpayment) (Sum of Items 16 and 20) 
    $pdf->SetXY(182, 173);
    $pdf->Write(21, '0  0  0');

    //Signature over Printed Name of President/Principal Officer/Authorized Representative
        //Signature(PNG image)
        $signature_path = 'mysign.png';
        $pdf->Image($signature_path, 30, 200, 30, 20, 'PNG');
        //Printed Name
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(25, 206);
        $pdf->Write(21, 'THOMAS RUDERDORF');
        //Title of Signatory
        $pdf->SetXY(37, 214);
        $pdf->Write(21, 'CEO');
        //TIN
        $pdf->SetXY(71, 214);
        $pdf->Write(21, '6785464');

    //Signature over Printed Name of Treasurer/ Assistant Treasurer
        //Signature(PNG image)
        $signature_path = 'treasurer.png';
        $pdf->Image($signature_path, 100, 200, 40, 20, 'PNG');
        //Printed Name
        $pdf->SetXY(100, 206);
        $pdf->Write(21, 'TREVOR SCHROURER');
        //Title of Signatory
        $pdf->SetXY(120, 214);
        $pdf->Write(21, 'Treasurer');
        //TIN
        $pdf->SetXY(154, 214);
        $pdf->Write(21, '6785464');

        //Return Font size to 12
        $pdf->SetFont('Arial', '', 12);

    // 22 Number of Attachments
    $pdf->SetXY(178, 209);
    $pdf->Write(21, '1  2  3');


/////////////////////////////////
//Part III – Details of Payment//
/////////////////////////////////

    // 23 Cash/Bank Debit Memo
        //Drawee Bank/Agency
        $pdf->SetXY(50, 229);
        $pdf->Write(21, 'I  D  R K  L');
        //Number
        $pdf->SetXY(72, 229);
        $pdf->Write(21, '1  2  3  4  5  6  7');
        //Date
        $pdf->SetXY(105, 229);
        $pdf->Write(21, '0  3  2  5  2  0  2  3');
        //Amount
        $pdf->SetXY(182, 229);
        $pdf->Write(21, '0  0  0');

    // 24 Check
        //Drawee Bank/Agency
        $pdf->SetXY(50, 235);
        $pdf->Write(21, 'I  D  R K  L');
        //Number
        $pdf->SetXY(72, 235);
        $pdf->Write(21, '1  2  3  4  5  6  7');
        //Date
        $pdf->SetXY(105, 235);
        $pdf->Write(21, '0  3  2  5  2  0  2  3');
        //Amount
        $pdf->SetXY(182, 235);
        $pdf->Write(21, '0  0  0');

    // 25 Tax Debit Memo
        //Number
        $pdf->SetXY(72, 241);
        $pdf->Write(21, '1  2  3  4  5  6  7');
        //Date
        $pdf->SetXY(105, 251);
        $pdf->Write(0, '0  3  2  5  2  0  2  3');
        //Amount
        $pdf->SetXY(182, 251);
        $pdf->Write(0, '0  0  0');


    // 26 Others (specify below)
    $pdf->SetXY(13, 250);
    $pdf->Write(21, 'X  X  X  X  X  X  X  X  X X X  X   X  X  X  X  X  X  X  X  X  X  X  X');

    // Machine Validation/Revenue Official Receipt Details [if not filed with an Authorized Agent Bank (AAB)]
    $pdf->SetFont('Arial', '', 20);
    $pdf->SetXY(13, 276);
    $pdf->Write(0, 'X  X  X  X  X  X  X  X  X X X  X');

    //Stamp of Receiving Office/AAB and Date of Receipt (RO’s Signature/Bank Teller’s Initial)
    $logo = 'stamp.png'; // path to the signature image
    $pdf->Image($logo, 145, 260, 40, 40, 'PNG');


/////////////////////////////////////....................PAGE 1 END......................////////////////////////////////////////

// import page 2
$pdf->AddPage();
$tplId = $pdf->importPage(2);
//templating
$pdf->useTemplate($tplId, 7, -18, 195);
$pdf->SetFont('Arial', '', 12);

// Taxpayer Identification Number (TIN)
$pdf->SetXY(13, 23);
$pdf->Write(21, '1  2  3   4  5  6  7  8  9 ');

// Registered Name
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(80, 23);
$pdf->Write(21, 'C   I   E   L   O       J   O   H   N      R       B   A   R   E  Z  A');

////////////////////////////////
//Part IV – Computation of Tax//
////////////////////////////////
    
    // 27 Sales/Receipts/Revenues/Fees
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(139, 34);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 28 Less: Sales Returns, Allowances and Discounts
    $pdf->SetXY(139, 40);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 29 Net Sales/Receipts/Revenues/Fees (Item 27 Less Item 28)
    $pdf->SetXY(139, 46);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 30 Less: Cost of Sales/Services
    $pdf->SetXY(139, 52);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 31 Gross Income from Operation (Item 29 Less Item 30)
    $pdf->SetXY(139, 58);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 32 Add: Other Taxable Income Not Subjected to Final Tax
    $pdf->SetXY(139, 64);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 33 Total Taxable Income (Sum of Items 31 and 32)
    $pdf->SetXY(139, 70);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 34 Ordinary Allowable Itemized Deductions (From Part VI Schedule I Item 18)
    $pdf->SetXY(139, 80);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 35 Special Allowable Itemized Deductions (From Part VI Schedule II Item 5)
    $pdf->SetXY(139, 86);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 36 N O L C O
    $pdf->SetXY(139, 92);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 37 Total Deductions (Sum of Items 34 to 36)
    $pdf->SetXY(139, 98);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 38 Optional Standard Deduction (OSD) (40% of Item 33)
    $pdf->SetXY(139, 110);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 39 Net Taxable Income/(Loss) 
    $pdf->SetXY(139, 116);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 40 Applicable Income Tax Rate
    $pdf->SetXY(182, 122);
    $pdf->Write(21, '0  0');
    // 41 Income Tax Due other than Minimum Corporate Income Tax 
    $pdf->SetXY(139, 128);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 42 MCIT Due
    $pdf->SetXY(139, 134);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0'); 
    // 43 Tax Due
    $pdf->SetXY(139, 140);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 44 Prior Year’s Excess Credits other than MCIT
    $pdf->SetXY(139, 150);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 45 Income Tax Payment under MCIT from Previous Quarter/s
    $pdf->SetXY(139, 156);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 46 Income Tax Payment under Regular/Normal Rate from Previous Quarter/s
    $pdf->SetXY(139, 162);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 47 Excess MCIT Applied this Current Taxable Year (From Part VI Schedule IV Item 4)
    $pdf->SetXY(139, 168);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 48 Creditable Tax Withheld from Previous Quarter/s per BIR Form No. 2307
    $pdf->SetXY(139, 174);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 49 Creditable Tax Withheld per BIR Form No. 2307 for the 4th Quarter
    $pdf->SetXY(139, 180);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 50 Foreign Tax Credits, if applicable
    $pdf->SetXY(139, 186);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 51 Tax Paid in Return Previously Filed, if this is an Amended Return
    $pdf->SetXY(139, 192);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 52 Special Tax Credits (To Part V Item 58)
    $pdf->SetXY(139, 198);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 53 - 54 Other Tax Credits/Payments (specify)
    $pdf->SetXY(22, 208);
    $pdf->Write(21, 'X  X  X  X  X  X   X  X  X  X  X  X');
    $pdf->SetXY(22, 214);
    $pdf->Write(21, 'X  X  X  X  X  X   X  X  X  X  X  X');

    $pdf->SetXY(139, 208);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    $pdf->SetXY(139, 214);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 55 Total Tax Credits/Payments (Sum of Items 44 to 54) (To Part II Item 15)
    $pdf->SetXY(139, 220);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 56 Net Tax Payable / (Overpayment) (Item 43 Less Item 55) (To Part II Item 16)
    $pdf->SetXY(139, 226);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    

/////////////////////////////////
//Part V – Tax Relief Availment//
/////////////////////////////////

    // 57 Special Allowable Itemized Deductions (Item 35 of Part IV x Applicable Income Tax Rate)
    $pdf->SetXY(139, 238);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 58 Add: Special Tax Credits (From Part IV Item 52)
    $pdf->SetXY(139, 244);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 59 Total Tax Relief Availment (Sum of Items 57 and 58)
    $pdf->SetXY(139, 250);
    $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');


/////////////////////////////////////....................PAGE 2 END......................////////////////////////////////////////

// import page 3
$pdf->AddPage();
$tplId = $pdf->importPage(3);
//templating
$pdf->useTemplate($tplId, 7, 2, 195);
$pdf->SetFont('Arial', '', 12);


// Taxpayer Identification Number (TIN)
$pdf->SetXY(13, 27.6);
$pdf->Write(21, '1  2  3   4  5  6  7  8  9 ');

// Registered Name
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(80, 28);
$pdf->Write(21, 'C   I   E   L   O       J   O   H   N      R       B   A   R   E  Z  A');

/////////////////////////
//Part VI – Schedules //
////////////////////////
    
    // Schedule I – Ordinary Allowable Itemized Deductions (attach additional sheet/s, if necessary)

    $pdf->SetFont('Arial', '', 12);

    // 1 Amortizations
            $pdf->SetXY(139, 43);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 2 Bad Debts
            $pdf->SetXY(139, 49);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 3 Charitable and Other Contributions
            $pdf->SetXY(139, 55);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 4 Depletion
            $pdf->SetXY(139, 61);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 5 Depreciation
            $pdf->SetXY(139, 67);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 6 Entertainment, Amusement and Recreation
            $pdf->SetXY(139, 73);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 7 Fringe Benefits
            $pdf->SetXY(139, 79);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 8 Interest
            $pdf->SetXY(139, 85);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 9 Losses
            $pdf->SetXY(139, 91);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 10 Pension Trusts
            $pdf->SetXY(139, 97);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 11 Rental
            $pdf->SetXY(139, 103);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 12 Research and Development
            $pdf->SetXY(139, 109);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 13 Salaries, Wages and Allowances
            $pdf->SetXY(139, 115);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 14 SSS, GSIS, Philhealth, HDMF and Other Contributions
            $pdf->SetXY(139, 121);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 15 Taxes and Licenses
            $pdf->SetXY(139, 127);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0'); 
    // 16 Transportation and Travel
            $pdf->SetXY(139, 133);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');

    // 17 Others (Deductions Subject to Withholding Tax and Other Expenses) [Specify below; Add additional sheet(s), if necessary]

        // a) Janitorial and Messengerial Services
                $pdf->SetXY(139, 145);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // b) Professional Fees
                $pdf->SetXY(139, 151);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // c) Security Services
                $pdf->SetXY(139, 157);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // d) ...
                $pdf->SetXY(22, 163);
                $pdf->Write(21, 'X  X  X  X X  X  X  X  X X  X X X  X  X  X  X  X X  X X  X  X');
                $pdf->SetXY(139, 163);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // e) ...
                $pdf->SetXY(22, 169);
                $pdf->Write(21, 'X  X  X  X X  X  X  X  X X  X X X  X  X  X  X  X X  X X  X  X');
                $pdf->SetXY(139, 169);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // f) ...
                $pdf->SetXY(22, 175);
                $pdf->Write(21, 'X  X  X  X X  X  X  X  X X  X X X  X  X  X  X  X X  X X  X  X');
                $pdf->SetXY(139, 175);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // g) ...
                $pdf->SetXY(22, 181);
                $pdf->Write(21, 'X  X  X  X X  X  X  X  X X  X X X  X  X  X  X  X X  X X  X  X');
                $pdf->SetXY(139, 181);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // h) ...
                $pdf->SetXY(22, 187);
                $pdf->Write(21, 'X  X  X  X X  X  X  X  X X  X X X  X  X  X  X  X X  X X  X  X');
                $pdf->SetXY(139, 187);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // i) ...
                $pdf->SetXY(22, 193);
                $pdf->Write(21, 'X  X  X  X X  X  X  X  X X  X X X  X  X  X  X  X X  X X  X  X');
                $pdf->SetXY(139, 193);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');

    //18 Total Ordinary Allowable Itemized Deductions (Sum of Items 1 to 17i) (To Part IV Item 34)
            $pdf->SetXY(139, 199);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
            

//Schedule II – Special Allowable Itemized Deductions (attach additional sheet/s, if necessary)

    // 1
        $pdf->SetXY(18, 215);
        $pdf->Write(21, 'X  X  X X X  X  X  X  X X  X X X  X  X ');
        $pdf->SetXY(90, 215);
        $pdf->Write(21,'X  X  X  X X X  X  X  X X');
        $pdf->SetXY(139, 215);
        $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 2
        $pdf->SetXY(18, 221);
        $pdf->Write(21, 'X  X  X X X  X  X  X  X X  X X X  X  X ');
        $pdf->SetXY(90, 221);
        $pdf->Write(21,'X  X  X  X X X  X  X  X X');
        $pdf->SetXY(139, 221);
        $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 3
        $pdf->SetXY(18, 227);
        $pdf->Write(21, 'X  X  X X X  X  X  X  X X  X X X  X  X ');
        $pdf->SetXY(90, 227);
        $pdf->Write(21,'X  X  X  X X X  X  X  X X');
        $pdf->SetXY(139, 227);
        $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 4
        $pdf->SetXY(18, 233);
        $pdf->Write(21, 'X  X  X X X  X  X  X  X X  X X X  X  X ');
        $pdf->SetXY(90, 233);
        $pdf->Write(21,'X  X  X  X X X  X  X  X X');
        $pdf->SetXY(139, 233);
        $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');

    // 5 Total Special Allowable Itemized Deductions (Sum of Items 1 to 4) (To Part IV Item 35)
        $pdf->SetXY(139, 239);
        $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');


/////////////////////////////////////....................PAGE 3 END......................////////////////////////////////////////

// import page 4
$pdf->AddPage();
$tplId = $pdf->importPage(4);
//templating
$pdf->useTemplate($tplId, 7, 2, 195);
$pdf->SetAutoPageBreak(true, 50);
$pdf->SetFont('Arial', '', 12);

// Taxpayer Identification Number (TIN)
$pdf->SetXY(13, 27.6);
$pdf->Write(21, '1  2  3   4  5  6  7  8  9 ');

// Registered Name
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(80, 28);
$pdf->Write(21, 'C   I   E   L   O       J   O   H   N      R       B   A   R   E  Z  A');


//Schedule III – Computation of Net Operating Loss Carry Over (NOLCO)
    $pdf->SetFont('Arial', '', 12);
    // 1 Gross Income (From Part IV Item 33)    
            $pdf->SetXY(139, 39);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 2 Less: Ordinary Allowable Itemized Deductions (From Part VI Schedule I Item 18)
            $pdf->SetXY(139, 45);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 3 Net Operating Loss (Item 1 Less Item 2) (To Schedule IIIA, Item 7A)
            $pdf->SetXY(139, 51);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');

//Schedule IIIA - Computation of Available Net Operating Loss Carry Over (NOLCO)
    // 4
        // Year Incurred
                $pdf->SetXY(33, 69);
                $pdf->Write(21, '2  0  2  3');
        // A) Amount
                $pdf->SetXY(71, 69);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // B) NOLCO Applied Previous Year/s
                $pdf->SetXY(139, 69);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // C) NOLCO Expired
                $pdf->SetXY(23, 105);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // D) NOLCO Applied Current Year
                $pdf->SetXY(81, 105);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // E) Net Operating Loss (Unapplied)[ E = A Less (B + C + D) ]
                $pdf->SetXY(139, 105);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 5
        // Year Incurred
                $pdf->SetXY(33, 75);
                $pdf->Write(21, '2  0  2  3');
        // A) Amount
                $pdf->SetXY(71, 75);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // B) NOLCO Applied Previous Year/s 
                $pdf->SetXY(139, 75);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // C) NOLCO Expired
                $pdf->SetXY(23, 111);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // D) NOLCO Applied Current Year
                $pdf->SetXY(81, 111);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // E) Net Operating Loss (Unapplied)[ E = A Less (B + C + D) ]
                $pdf->SetXY(139, 111);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 6    
        // Year Incurred
                $pdf->SetXY(33, 82);
                $pdf->Write(21, '2  0  2  3');
        // A) Amount
                $pdf->SetXY(71, 82);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // B) NOLCO Applied Previous Year/s 
                $pdf->SetXY(139, 82);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // C) NOLCO Expired
                $pdf->SetXY(23, 117);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // D) NOLCO Applied Current Year
                $pdf->SetXY(81, 117);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // E) Net Operating Loss (Unapplied)[ E = A Less (B + C + D) ]
                $pdf->SetXY(139, 117);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
    // 7
        // Year Incurred
                $pdf->SetXY(33, 88);
                $pdf->Write(21, '2  0  2  3'); 
        // A) Amount
                $pdf->SetXY(71, 88);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // B) NOLCO Applied Previous Year/s 
                $pdf->SetXY(139, 88);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // C) NOLCO Expired
                $pdf->SetXY(23, 123);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // D) NOLCO Applied Current Year
                $pdf->SetXY(81, 123);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
        // E) Net Operating Loss (Unapplied)[ E = A Less (B + C + D) ]
                $pdf->SetXY(139, 123);
                $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');

    // 8 Total NOLCO (Sum of Items 4D to 7D) (To Part IV, Item 36)
        $pdf->SetXY(81, 129);
        $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
                
//Schedule IV – Computation of Minimum Corporate Income Tax (MCIT)
   // 1 
        // Year 
                $pdf->SetXY(18, 156);
                $pdf->Write(0, '2  0  2  3');
        // A) Normal Income Tax as Adjusted 
                $pdf->SetXY(32, 156);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // B) MCIT 
                $pdf->SetXY(86, 156);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // C) Excess MCIT over Normal Income Tax
                $pdf->SetXY(139, 156);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // D) Excess MCIT Applied/Used in Previous Years
                $pdf->SetXY(18, 190);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // E) Expired Portion of Excess MCIT
                $pdf->SetXY(61.5, 190);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // F) Excess MCIT Applied this Current Taxable Year
                $pdf->SetXY(109, 190);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // G) Balance of Excess MCIT Allowable as Tax Credit for Succeeding Year/s [ G = C Less (D + E + F) ]
                $pdf->SetXY(139, 190);
                $pdf->Write(0, '            0  0  0   0  0  0  0  0  0'); 
   // 2  
        // Year 
                $pdf->SetXY(18, 162);
                $pdf->Write(0, '2  0  2  3');
        // A) Normal Income Tax as Adjusted 
                $pdf->SetXY(32, 162);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // B) MCIT 
                $pdf->SetXY(86, 162);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // C) Excess MCIT over Normal Income Tax
                $pdf->SetXY(139, 162);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // D) Excess MCIT Applied/Used in Previous Years
                $pdf->SetXY(18, 196);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // E) Expired Portion of Excess MCIT
                $pdf->SetXY(61.5, 196);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // F) Excess MCIT Applied this Current Taxable Year
                $pdf->SetXY(109, 196);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // G) Balance of Excess MCIT Allowable as Tax Credit for Succeeding Year/s [ G = C Less (D + E + F) ] 
                $pdf->SetXY(139, 196);
                $pdf->Write(0, '            0  0  0   0  0  0  0  0  0');
   // 3
        // Year 
                $pdf->SetXY(18, 168);
                $pdf->Write(0, '2  0  2  3');
        // A) Normal Income Tax as Adjusted
                $pdf->SetXY(32, 168);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0'); 
        // B) MCIT 
                $pdf->SetXY(86, 168);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // C) Excess MCIT over Normal Income Tax
                $pdf->SetXY(139, 168);
                $pdf->Write(0, '    0  0  0  0  0   0  0  0  0  0  0');
        // D) Excess MCIT Applied/Used in Previous Years
                $pdf->SetXY(18, 202);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // E) Expired Portion of Excess MCIT
                $pdf->SetXY(61.5, 202);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // F) Excess MCIT Applied this Current Taxable Year
                $pdf->SetXY(109, 202);
                $pdf->Write(0, '0  0  0   0  0  0  0  0  0');
        // G) Balance of Excess MCIT Allowable as Tax Credit for Succeeding Year/s [ G = C Less (D + E + F) ]
                $pdf->SetXY(139, 202);
                $pdf->Write(0, '            0  0  0   0  0  0  0  0  0'); 

    // 4  Total Excess MCIT Applied (Sum of Items 1F to 3F) (To Part IV Item 47)
        $pdf->SetXY(109, 208);
        $pdf->Write(0, '0  0  0   0  0  0  0  0  0');

// Schedule V – Reconciliation of Net Income per Books Against Taxable Income (attach additional sheet/s, if necessary)
    // 1 Net Income/(Loss) per Books
            $pdf->SetXY(139, 209);
            $pdf->Write(21, '0  0  0  0  0  0   0  0  0  0  0  0');
   //  Add: Non-Deductible Expenses/Taxable Other Income
        // 2
                $pdf->SetXY(18, 229);
                $pdf->Write(0, '0  0  0  0  0  0   0  0  0  0  0  0');

                $pdf->SetXY(139, 229);
                $pdf->Write(0, '0  0  0  0  0  0   0  0  0  0  0  0'); 
        // 3
                $pdf->SetXY(18, 235);
                $pdf->Write(0, '0  0  0  0  0  0   0  0  0  0  0  0');
                
                $pdf->SetXY(139, 235);
                $pdf->Write(0, '0  0  0  0  0  0   0  0  0  0  0  0'); 
        // 4
                $pdf->SetXY(139, 241);
                $pdf->Write(0, '0  0  0  0  0  0   0  0  0  0  0  0');

   // Less: A) Non-Taxable Income and Income Subjected to Final Tax 

        // 5
                $pdf->SetXY(18, 254);
                $pdf->Write(-8, '0  0  0  0  0  0   0  0  0  0  0  0');
                
                $pdf->SetXY(139, 254);
                $pdf->Write(-8, '0  0  0  0  0  0   0  0  0  0  0  0'); 
        // 6
                $pdf->SetXY(18, 263);
                $pdf->Write(-16, '0  0  0  0  0  0   0  0  0  0  0  0');
                
                $pdf->SetXY(139, 263);
                $pdf->Write(-16, '0  0  0  0  0  0   0  0  0  0  0  0');
        // 7
                $pdf->SetXY(18, 286);
                $pdf->Write(-40, '0  0  0  0  0  0   0  0  0  0  0  0');
                
                $pdf->SetXY(139, 286);
                $pdf->Write(-40, '0  0  0  0  0  0   0  0  0  0  0  0');
        // 8 
                $pdf->SetXY(18, 297);
                $pdf->Write(-50, '0  0  0  0  0  0   0  0  0  0  0  0');
                
                $pdf->SetXY(139, 297);
                $pdf->Write(-50, '0  0  0  0  0  0   0  0  0  0  0  0');
        // 9 Total (Sum of Items 5 to 8)
                $pdf->SetXY(139, 313);
                $pdf->Write(-70, '0  0  0  0  0  0   0  0  0  0  0  0');
        // 10 Net Taxable Income/(Loss) (Item 4 Less Item 9)
                $pdf->SetXY(139, 323);
                $pdf->Write(-77, '0  0  0  0  0  0   0  0  0  0  0  0');

                

/////////////////////////////////////....................PAGE 4 END......................////////////////////////////////////////


$pdf->Output();            
?>
