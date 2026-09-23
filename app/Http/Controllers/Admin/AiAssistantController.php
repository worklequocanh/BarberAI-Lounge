<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiConversation;
use Illuminate\View\View;

class AiAssistantController extends Controller
{
    /**
     * Display a listing of AI recommendations and history.
     */
    public function index(): View
    {
        $conversations = AiConversation::with(['user', 'recommendations'])->latest()->paginate(10);

        return view('admin.ai.index', compact('conversations'));
    }
}
