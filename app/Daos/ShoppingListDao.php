<?php


namespace App\Daos;


use App\Value\ShoppingList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShoppingListDao extends Model
{
    protected $table = 'shopping_lists';
    protected $primaryKey = self::PROPERTY_ID;

    public $timestamps = false;

    public const PROPERTY_ID = "id";
    public const PROPERTY_USER_ID = "user_id";
    public const PROPERTY_INGREDIENTS = "ingredients";

    protected $fillable = [self::PROPERTY_ID, self::PROPERTY_USER_ID, self::PROPERTY_INGREDIENTS];

    public function add(ShoppingList $shoppingList): int
    {
        $model = new self();
        $model->setAttribute(self::PROPERTY_USER_ID, $shoppingList->userId());
        $model->setAttribute(self::PROPERTY_INGREDIENTS, \Safe\json_encode($shoppingList->ingredients()->toArray()));
        $model->save();

        return $model->getAttribute(self::PROPERTY_ID);
    }

    public function getById(int $id): self
    {
        $model = new self();
        /** @phpstan-ignore-next-line */
        return $model->newQuery()->findOrFail($id);
    }

    public function getByUserId(int $id): self
    {
        /** @phpstan-ignore-next-line */
        return $this->newQuery()->where(self::PROPERTY_USER_ID, '=', $id)->firstOrFail();
    }

    /** @throws ModelNotFoundException */
    public function deleteById(int $id)
    {
        $model = new self();
        $model = $model->newQuery()->findOrFail($id);
        $model->delete();
    }

    public function id(): int
    {
        return $this->getAttribute(self::PROPERTY_ID);
    }

    public function userId(): int
    {
        return $this->getAttribute(self::PROPERTY_USER_ID);
    }

    public function ingredients(): string
    {
        return $this->getAttribute(self::PROPERTY_INGREDIENTS);
    }
}
