<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace app\Models;


use app\Forms\SearchForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Image extends Model
{
    protected $table = 'image';

    /**
     * Searching images here
     * @param SearchForm $form
     * @return Image[]
     */
    public static function searchFromForm(SearchForm $form)
    {
        /** @var $query Builder */
        $query = static::query();
        $query->orderBy('create_date', 'desc');
        $query->limit(20);
        $query->offset($form->getStep()*20);
        $i=0;
        foreach ($form->getIncludeTags() as $includeTagId)
        {
            $i++;
            $query->join('tag_image as tg_'.$i, function($join) use ($i, $includeTagId)
                {
                    $join->on('tg_'.$i.'.image_id', '=', 'image.id')
                        ->where('tg_'.$i.'.tag_id', '=', $includeTagId);
                });
        }

        foreach ($form->getExcludeTags() as $excludeTagId)
        {
            $i++;
            $query->leftJoin('tag_image as tg_'.$i, function($join) use ($i, $excludeTagId)
                {
                    $join->on('tg_'.$i.'.image_id', '=', 'image.id')
                        ->where('tg_'.$i.'.tag_id', '=', $excludeTagId);
                });
            $query->whereNull('tg_'.$i.'.tag_id');
        }

        $images = $query->get();
        return $images?:[];
    }
} 