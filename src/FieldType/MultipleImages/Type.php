<?php
declare(strict_types=1);

namespace App\FieldType\MultipleImages;

use App\Form\Type\MultipleImagesType;
use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Symfony\Component\Form\FormInterface;


class Type extends GenericType implements FieldValueFormMapperInterface
{
  public function getFieldTypeIdentifier(): string
  {
      return 'multipleImages';
  }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->fieldDefinition;
        $fieldForm->add('value', MultipleImagesType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName(),
        ]);
    }
}