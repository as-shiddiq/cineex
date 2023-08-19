<?php
	use Dompdf\Dompdf;
	use Dompdf\Options;
	use Dompdf\FontMetrics; 
	use CodeIgniter\HTTP\Response;
	function generatePdf($html='',$nama_file='report',$paper='legal',$orient='landscape',$method='inline',$folder='',$watermark=''){

        $response = service('response');
        $response->setHeader('Content-type', 'application/pdf');

		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		// $dompdf = new Dompdf();
		$dompdf->loadHtml($html);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper($paper,$orient);

		// Render the HTML as PDF
		$dompdf->render();

		if($watermark!=''){

			// Instantiate canvas instance 
			$canvas = $dompdf->getCanvas(); 
			 
			// Instantiate font metrics class 
			$fontMetrics = new FontMetrics($canvas, $options); 
			 
			// Get height and width of page 
			$w = $canvas->get_width(); 
			$h = $canvas->get_height(); 
			 
			// Get font family file 
			$font = $fontMetrics->getFont('helvetica'); 
			 
			// Specify watermark text 
			$text = $watermark; 
			 
			// Get height and width of text 
			$txtHeight = $fontMetrics->getFontHeight($font, 80); 
			$textWidth = $fontMetrics->getTextWidth($text, $font, 80); 
			 
			// Set text opacity 
			$canvas->set_opacity(.1); 
			 
			// Specify horizontal and vertical position 
			$x = (($w-$textWidth)/2)+50; 
			$y = (($h-$txtHeight)/2)+50; 
			 
			// Writes text at the specified x and y coordinates 
			$canvas->text($x, $y, $text, $font, 80,[0,0,0],1,0.0,330); 
		}

		// Output the generated PDF to Browser
		// $dompdf->stream();
		if($method=='save'){
			// Render the HTML as PDF
		 	$output = $dompdf->output();
		    file_put_contents('doc/'.$folder.'/'.$nama_file.".pdf", $output);
		}
		elseif($method=='download'){
			// Render the HTML as PDF
			$dompdf->stream($nama_file.".pdf", array("Attachment" => true));

		}
		else{
			$dompdf->stream($nama_file.".pdf", array("Attachment" => false));
		}


	}

	// function generatePdf($html='',$nama_file='report',$paper='legal',$orientation='L',$method="inline"){
	// $config=[
	// 	'orientation' => $orientation,
	// 	'format'=>$paper
	// ];
	// $mpdf = new \Mpdf\Mpdf($config);

	// $mpdf->WriteHTML($html);
	// $mpdf->shrink_tables_to_fit = 0;
	// // \Mpdf\Output\Destination::FILE
	// if($method=='inline'){
	// 	$mpdf->Output();
	// 	// You need to write this
	// 	$file = $nama_file.'.pdf';
	// 	$response = new \Zend\Http\Response\Stream();
	// 	$response->setStream(fopen($file, 'r'));
	// 	$response->setStatusCode(200);
	// 	$response->setStreamName(basename($file));
	// 	$headers = new \Zend\Http\Headers();
	// 	$headers = addHeaders(array(
	// 	    'Content-Disposition' => 'attachment; filename"'.basename($file).'"',
	// 	    'Content-Type' => 'application/pdf',
	// 	    'Content-Length' => filesize($file),
	// 	    'Expires' => '@0',
	// 	    'Cache-Control' => 'must-revalidate',
	// 	    'Pragma' => 'public'
	// 	));

	// 	$response->setHeaders($headers);
	// 	return $response;
	// }
	// elseif($method=='download'){
	// 	$mpdf->Output($nama_file.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);
	// }
	// elseif($method=='save'){
	// 	$mpdf->Output($nama_file.'.pdf', \Mpdf\Output\Destination::FILE);
	// }
	// elseif($method=='string'){
	// 	$mpdf->Output($nama_file.'.pdf', \Mpdf\Output\Destination::STRING_RETURN);
	// }

	// $dompdf->stream($nama_file.".pdf", array("Attachment" => false));


// }
