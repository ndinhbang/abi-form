<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Resources\Form;
use App\Forms;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $form = new Form();
        $form->schema([
            Forms\Components\TextInput::make('name')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('slug')
                ->url()
                ->required(),
        ]);

        foreach ($form->getSchema() as $schema) {
            dump($schema);
        }

        dump($form);
    }
}
