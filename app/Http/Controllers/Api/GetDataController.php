<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Materi;
use App\Models\Question;
use App\Models\SubMateri;
use Illuminate\Http\Request;

class GetDataController extends BaseController
{
    public function materi() {
        $data = Materi::all();

        if ($data->isEmpty()) {
            return $this->sendError('Materi Not Found');
        }

        return $this->sendResponse($data, 'Success Get Materi');
    }

    public function submateri($materi_id) {
        $data = SubMateri::where('materi_id', $materi_id)->get();

        if ($data->isEmpty()) {
            return $this->sendError('SubMateri Not Found');
        }

        return $this->sendResponse($data, 'Success Get SubMateri');
    }

    public function question($submateri_id) {
        $data = Question::where('sub_materi_id', $submateri_id)->get();

        if ($data->isEmpty()) {
            return $this->sendError('Question Not Found');
        }

        return $this->sendResponse($data, 'Success Get Question');
    }

    public function answer($question_id) {
        $data = Answer::where('question_id', $question_id)->get();

        if ($data->isEmpty()) {
            return $this->sendError('Answer Not Found');
        }

        return $this->sendResponse($data, 'Success Get Answer');
    }
}
