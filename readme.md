# Moxar\Validator

## Introduction

This package is meant to enhance Laracas's validator functionalities. It allows you to make a single validator per model and keep specifying rules for the different forms the model is related to. All you have to do is to declare the rules needed in the validator class.

1. The `rules` array is shared by every form related to the model.
2. An additional array can be defined for rules only used in a specific form.

## Features

1. Easy use
2. A single validator class per model
3. Additional valiation rules
4. Built in validation rules for translatable elements (compatible with dimsav/translatable)

## Installation

Install using composer:

1. Add `"moxar/validation": "dev-master"` to your composer file
2. Run `composer update`

## Usage

Let's assume you have an `Article` model with a `picture` field connected to a `file input`.
The model also has a `user_id` field which is a foreign key to a `User` model.
The `Article` model uses an `ArticleTranslation` model which table is `article_translations`.
The `article_translations` table contains a `title` and a `locale` field

Here is your validation class:

    use Moxar\Validation\Validator;
    use Moxar\Validation\Traits\Translatable;

    class ArticleValidator extends Validator {
    
        // use the translatable trait since this model uses a translation table and 
        // some of its rules depend on translation.
        use Translatable;
    
        $rules = [
            // this rules will apply when using any action
            'title'     => 'required|langUnique:article_translations,title',
            'picutre'   => 'image|min-width:200|ratio:16,9',
        ];
        
        $store = [
            // this rule will apply only when using the 'store' action
            'user_id'   => 'required',
            'picture'   => 'required',
        ];
    }
    
Here is your controller class:

    class ArticleController extends Controller {
    
        // inject your validator here
        public function __construct(ArticleValidator $validator) {
            $this->validator = $validator;
        }
    
        // this is your store method
        public function store() {
        
            // like with laracast's validator, use a try/catch to test our validation rules.
            try {
            
                // here is the trick: you have to tell the validator 
                // what "action" you are using, which means what rules the
                // validator has to check. In this case, 'store'.
                $this->validator->action('store')->validate(Input::all());
            }
            catch(FormValidationException $e) {
            
                // if an error occurs, redirect back with inputs and errors.
                return Redirect::back()->withInput()->withErrors($e->getErrors());
            }
            
            // ... logic here
        }
    }

## Additional rules

This package provides some additional rules:

### Images
* ratio:**width,height** checks the ratio of an image
* minWidth:**min** checks the minimal width of an image
* maxWidth:**max** checks the maximal width of an image
* width:**value** checks the width of an image
* minHeight:**min** checks the minimal height of an image
* maxHeight:**max** checks the maximal height of an image
* height:**value** checks the height of an image

### Translation

* uniqueLang:**table,field,id to ignore** checks if the given field is unique in the table.

Note about `unique`: Assuming you provide an `id` field, the `unique` rule will not trigger false if you try to update a model.
`uniqueLang` behaves the same if you provide a `iso[id]` field, with `iso` being the iso of the lang and `id` being the id of the translation line.

### Strings

* fullName: checks if the given field is made of strings, spaces or hyphen (regex: `#^([A-Za-z -])*$#`)

## Validation messages

To get pretty validation messages when using this package, add the following lines to your `app/language/<lang>/validation.php` file.

    /*
    |--------------------------------------------------------------------------
    | Moxar\Validator package translations
    |--------------------------------------------------------------------------
    |
    | Here are the default translations for Moxar\Validator package's additional rules.
    |
    */
    
    "ratio"                => "The :attribute image ratio is not :width::height.",
    "min_width"            => "The :attribute image min width is :minpx.",
    "max_width"            => "The :attribute image max width is :maxpx.",
    "width"                => "The :attribute image width must be :valuepx.",
    "min_height"           => "The :attribute image min height is :minpx.",
    "max_height"           => "The :attribute image max height is :maxpx.",
    "height"               => "The :attribute image height must be :valuepx.",
    "unique_lang"          => "The :attribute has already been taken.",
    "full_name"            => "The :attribute must be a full name.",
