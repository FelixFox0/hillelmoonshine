<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserve;

use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<Reserve>
 */
class ReserveResource extends ModelResource
{
    protected string $model = Reserve::class;

    protected string $title = 'Резервування користувача';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Ім\'я замовника','name'),
                Text::make('Телефон замовника','phone'),

                Text::make('Початок резервування','start'),
                Text::make('Кінець резервування','end'),
                Text::make('Id користувача','user_id')->hideOnIndex(),
                Text::make('Користувач','user_id', function (Reserve $reserve){
                    return User::find($reserve->user_id)->name;
                })
                    ->hideOnAll()
                    ->showOnIndex(),
                Text::make('Email користувача','user_id', function (Reserve $reserve){
                    return User::find($reserve->user_id)->email;
                })
                    ->hideOnAll()
                    ->showOnIndex(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
