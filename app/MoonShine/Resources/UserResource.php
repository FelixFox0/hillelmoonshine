<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Користувачі';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Ім\'я', 'name'),
                Text::make('Email'),
                Text::make('Пароль', 'password')
                    ->hint('Будьте обережні')
                    ->hideOnIndex(),
                Text::make('Зареєстрованний', 'created_at')
                    ->readonly()
                    ->hideOnCreate(),
                Text::make('Зміненний', 'updated_at')
                    ->disabled()
                    ->hideOnCreate(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
