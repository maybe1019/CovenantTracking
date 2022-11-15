<?php

namespace Axistrustee\Compliance\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Axistrustee\Compliance\Models\Compliancetool;
use Storage; 
//use Illuminate\Http\UploadedFile;

class CompliancetoolController extends Controller
{
    //

    public function store(Request $request) 
    {
    	
    	/*$files = Storage::disk('s3')->files('/');
		foreach ($files as $file) {
			print_r($file);
		}
		die;
    	foreach($request->files as $file)
        {
        	foreach($file as $upload)
        	{

	            $name= $upload->getClientOriginalName().'_'.time();
	            $filePath = '/' . $name;
	            Storage::disk('s3')->put($filePath, file_get_contents($upload));
	            return back()->with('success','Image Uploaded successfully');
        	}
        }
        if (Storage::disk('s3')->exists('1656308436_logo.jpg')) {
    			
			$url = Storage::disk('s3')->url('1656308436_logo.jpg');
		}*/
    	$current_user = \Auth::user()->id;
    	$docnames= [];
    	foreach($request->files as $file)
        {
        	foreach($file as $upload)
        	{

	           	$name= time().'_'.$upload->getClientOriginalName();
	            $filePath = '/' . $name;
	            $docnames[] = $name;
	            $path = Storage::disk('s3')->put('/'.$name, $upload);
	            if (!Storage::disk('s3')->exists($name)) {    			
					//$url = Storage::disk('s3')->url('1656308436_logo.jpg');
					return response()->json('Error uploading file '.$name.' Compliance could not be created.');
				}
        	}
        }

        $docnames_json = json_encode($docnames);
    	$compliancetool = new Compliancetool([
            'clcode' => $request->clcode,
            'isin' => $request->isin,
            'docName' => $request->docName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'priority' => $request->priority,
            'secured' => $request->secured,
            'inconsistencyTreatment' => $request->inconsistencyTreatment,
            'clientReference' => $request->clientReference,
            'mailCC' => $request->mailCC,
            'documentNames' => $docnames_json,
            'userId' => $current_user,
        ]);
        $compliancetool->save();

        return response()->json('Compliance created!');
    }

    public function fetchClients(Request $request) 
    {
    	$current_user = \Auth::user()->id;
    	$org_id = DB::table('users')->where('id', $current_user)->value('organization_id');
    	$clients = DB::table('clients')->get()->where('organization_id', $org_id);
    	$client_data = [];
    	$i = 0;
    	foreach ($clients as $client) {
        	$client_data[$i]['id'] = $client->id;
        	$client_data[$i]['name'] = $client->name;
        	$i++;
    	}
    	echo json_encode($client_data); die;

    }
}