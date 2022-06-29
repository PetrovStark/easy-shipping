<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Broker;

class SpreadsheetController extends Controller
{
    /**
     * Uploads the spreadsheet in local storage.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'shipping_csv' => 'required|mimetypes:text/csv,text/plain'
        ]);

        if (!$request->hasFile('shipping_csv') || !$request->file('shipping_csv')->isValid()) {
            return $this->redirect('error', 'Send a valid ".csv" file.');
        }

        $file = $request->file('shipping_csv');

        if (explode('.', $file->getClientOriginalName())[1] != 'csv') {
            return $this->redirect('error', 'Your file does not match with the ".csv" extension.');
        }

        $name = uniqid(date('HisYmd'));            
        $nameFile = "{$name}.csv";
        $upload = $file->storeAs('spreadsheets', $nameFile);

        if (!$upload) {
            return $this->redirect('error', 'Unknow file upload error.');
        }

        $Broker = new Broker();
        $Broker->produceBasicPublish(asset($upload), 'csv_paths');

        return redirect()
            ->route('welcome', ['show_stage_two' => true])
            ->with('success', 'Your file was successfully uploaded.');
    }

    /**
     * Redirects user.
     * 
     * @param string $key
     * @param string $value
     * @param bool $input
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirect($key, $value, $input=true)
    {
        if (!$input) {
            return redirect()
                ->back()
                ->with($key, $value);
        }

        return redirect()
            ->back()
            ->with($key, $value)
            ->withInput();
    }
}
