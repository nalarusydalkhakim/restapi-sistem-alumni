<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class AlumniCardController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generateAlumniCard($user_id)
    {
        // $data = [
        //     'title' => 'Welcome to ItSolutionStuff.com',
        //     'date' => date('m/d/Y')
        // ];
          
        // $pdf = PDF::loadView('card', $data)->setOptions(['defaultFont' => 'sans-serif','isRemoteEnabled' => true]);
    
        // return $pdf->stream('itsolutionstuff.pdf');

        $pdf = new Dompdf();
        $html = view('card');
        $pdf->loadHtml($html, 'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $filename = "Hi!";
        return $pdf->stream($filename, ["Attachment" => false]);
    }
}
