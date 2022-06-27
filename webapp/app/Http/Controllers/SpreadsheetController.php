<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpreadsheetController extends Controller
{
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

        return redirect()
            ->route('welcome', ['show_stage_two' => true])
            ->with('success', 'Your file was successfully uploaded.');
    }

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
