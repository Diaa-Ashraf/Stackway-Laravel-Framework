<?php

namespace Stackway\Core\Base;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**
     * Default: Arabic validation messages.
     * Override in child classes for custom messages.
     */
    public function messages(): array
    {
        return [
            'required'  => ':attribute مطلوب',
            'string'    => ':attribute يجب أن يكون نصًا',
            'email'     => ':attribute يجب أن يكون بريدًا إلكترونيًا صالحًا',
            'max'       => ':attribute يجب ألا يتجاوز :max حرفًا',
            'min'       => ':attribute يجب أن يكون :min أحرف على الأقل',
            'unique'    => ':attribute مستخدم بالفعل',
            'exists'    => ':attribute غير موجود',
            'numeric'   => ':attribute يجب أن يكون رقمًا',
            'integer'   => ':attribute يجب أن يكون عددًا صحيحًا',
            'boolean'   => ':attribute يجب أن يكون صحيحًا أو خاطئًا',
            'date'      => ':attribute يجب أن يكون تاريخًا صالحًا',
            'image'     => ':attribute يجب أن يكون صورة',
            'mimes'     => ':attribute يجب أن يكون من نوع: :values',
            'confirmed' => 'تأكيد :attribute غير متطابق',
            'array'     => ':attribute يجب أن يكون مصفوفة',
            'in'        => ':attribute غير صالح',
            'url'       => ':attribute يجب أن يكون رابطًا صالحًا',
        ];
    }
}
