<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace app\Controllers;


use app\Forms\SearchForm;
use app\Models\Image;
use app\Models\Tag;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $form = new SearchForm($this->request);
        $tags = Tag::query()->lists('name','id');
        $images = Image::searchFromForm($form);

        $this->render('main.twig',['form'=>$form,'tags'=>$tags, 'images' => $images]);

    }
} 