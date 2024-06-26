<?php

namespace App\Http\Controllers\Api;

use App\Models\Answer;
use App\Models\Example;
use App\Models\ExampleImage;
use App\Models\Materi;
use App\Models\Question;
use App\Models\SubMateri;
use App\Models\SubMateriImage;

class GetDataController extends BaseController
{
    public function materi()
    {
        $data = Materi::all();

        if ($data->isEmpty()) {
            return $this->sendError('Materi Not Found');
        }

        return $this->sendResponse($data, 'Success Get Materi');
    }

    public function submateri($materi_id)
    {
        $data = SubMateri::where('materi_id', $materi_id)->get();

        if ($data->isEmpty()) {
            return $this->sendError('SubMateri Not Found');
        }

        return $this->sendResponse($data, 'Success Get SubMateri');
    }

    public function submateriDetail($sub_materi_id)
    {
        $data = SubMateri::find($sub_materi_id);
        $photo = SubMateriImage::where('sub_materi_id', $sub_materi_id)->get();

        if (!$data) {
            return $this->sendError('SubMateri Not Found');
        }

        $allData = [
            'data' => $data,
            'photos' => $photo,
        ];

        return $this->sendResponse($allData, 'Success Get SubMateri Detail');
    }

    public function example($sub_materi_id){
        $data = Example::where('sub_materi_id', $sub_materi_id)->first();
        $photo = ExampleImage::where('example_id', $data->id)->get();

        if (!$data) {
            return $this->sendError('Example Not Found');
        }

        $allData = [
            'data' => $data,
            'photos' => $photo,
        ];

        return $this->sendResponse($allData, 'Success Get Example Detail');
    }

    public function question($submateri_id)
    {
        $data = Question::where('sub_materi_id', $submateri_id)->get();

        if ($data->isEmpty()) {
            return $this->sendError('Question Not Found');
        }

        return $this->sendResponse($data, 'Success Get Question');
    }

    public function answer($question_id)
    {
        $data = Answer::where('question_id', $question_id)->inRandomOrder()->get();

        if ($data->isEmpty()) {
            return $this->sendError('Answer Not Found');
        }

        return $this->sendResponse($data, 'Success Get Answer');
    }
}
