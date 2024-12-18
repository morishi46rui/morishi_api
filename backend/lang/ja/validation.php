<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデタークラスにより使用されるデフォルトのエラー
    | メッセージです。サイズルールのようにいくつかのバリデーションを
    | 持っているものもあります。メッセージはご自由に調整してください。
    |
    */

    'accepted' => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url' => ':attributeが有効なURLではありません。',
    'after' => ':attributeには、:date以降の日付を指定してください。',
    'after_or_equal' => ':attributeには、:date以降または同日の日付を指定してください。',
    'alpha' => ':attributeには、アルファベッドのみ使用できます。',
    'alpha_dash' => ':attributeには、アルファベッド、数字、ダッシュ(-)、アンダースコア(_)が使用できます。',
    'alpha_num' => ':attributeには、アルファベッドと数字が使用できます。',
    'array' => ':attributeには、配列を指定してください。',
    'ascii' => ':attributeには、半角の英数字と記号のみを使用してください。',
    'before' => ':attributeには、:date以前の日付を指定してください。',
    'before_or_equal' => ':attributeには、:date以前または同日の日付を指定してください。',
    'between' => [
        'array' => ':attributeの項目数は:minから:maxの間にしてください。',
        'file' => ':attributeのファイルサイズは:min KBから:max KBの間にしてください。',
        'numeric' => ':attributeの値は:minから:maxの間にしてください。',
        'string' => ':attributeの文字数は:min文字から:max文字の間にしてください。',
    ],
    'boolean' => ':attributeには、trueまたはfalseを指定してください。',
    'can' => ':attributeには、許可されていない値が含まれています。',
    'confirmed' => ':attributeの確認が一致しません。',
    'contains' => ':attributeには、必要な値が含まれていません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attributeには、有効な日付を指定してください。',
    'date_equals' => ':attributeには、:dateと同じ日付を指定してください。',
    'date_format' => ':attributeは、:format形式で指定してください。',
    'decimal' => ':attributeには、:decimal桁の小数を指定してください。',
    'declined' => ':attributeは拒否されなければなりません。',
    'declined_if' => ':otherが:valueの場合、:attributeは拒否されなければなりません。',
    'different' => ':attributeと:otherは異なる値にしてください。',
    'digits' => ':attributeは:digits桁にしてください。',
    'digits_between' => ':attributeは:min桁から:max桁の間にしてください',
    'dimensions' => ':attributeの画像サイズが無効です。',
    'distinct' => ':attributeに重複した値があります。',
    'doesnt_end_with' => ':attributeは、次のいずれかで終わってはいけません: :values。',
    'doesnt_start_with' => ':attributeは、次のいずれかで始まってはいけません: :values。',
    'email' => ':attributeには、有効なメールアドレスを指定してください。',
    'ends_with' => ':attributeは、次のいずれかで終わらなければなりません: :values。',
    'enum' => '選択された:attributeは無効です。',
    'exists' => '選択された:attributeは無効です。',
    'extensions' => ':attributeには、次の拡張子のいずれかを持つファイルを指定してください: :values。',
    'file' => ':attributeには、ファイルを指定してください。',
    'filled' => ':attributeには、値を指定してください。',
    'gt' => [
        'array' => ':attributeの項目数は:value個より多くしてください。',
        'file' => ':attributeのファイルサイズは:value KBより大きくしてください。',
        'numeric' => ':attributeの値は:valueより大きくしてください。',
        'string' => ':attributeの文字数は:value文字より多くしてください。',
    ],
    'gte' => [
        'array' => ':attributeの項目数は:value個以上にしてください。',
        'file' => ':attributeのファイルサイズは:value KB以上にしてください。',
        'numeric' => ':attributeの値は:value以上にしてください。',
        'string' => ':attributeの文字数は:value文字以上にしてください。',
    ],
    'hex_color' => ':attributeには、有効な16進数の色を指定してください。',
    'image' => ':attributeには、画像ファイルを指定してください。',
    'in' => '選択された:attributeは無効です。',
    'in_array' => ':attributeは:otherに存在しなければなりません。',
    'integer' => ':attributeには、整数を指定してください。',
    'ip' => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4' => ':attributeには、有効なIPv4アドレスを指定してください。',
    'ipv6' => ':attributeには、有効なIPv6アドレスを指定してください。',
    'json' => ':attributeには、有効なJSON文字列を指定してください。',
    'list' => ':attributeには、リストを指定してください。',
    'lowercase' => ':attributeには、小文字を指定してください。',
    'lt' => [
        'array' => ':attributeの項目数は:value個未満にしてください。',
        'file' => ':attributeのファイルサイズは:value KB未満にしてください。',
        'numeric' => ':attributeの値は:value未満にしてください。',
        'string' => ':attributeの文字数は:value文字未満にしてください。',
    ],
    'lte' => [
        'array' => ':attributeの項目数は:value個以下にしてください。',
        'file' => ':attributeのファイルサイズは:value KB以下にしてください。',
        'numeric' => ':attributeの値は:value以下にしてください。',
        'string' => ':attributeの文字数は:value文字以下にしてください。',
    ],
    'mac_address' => ':attributeには、有効なMACアドレスを指定してください。',
    'max' => [
        'array' => ':attributeの項目数は:max個以下にしてください。',
        'file' => ':attributeのファイルサイズは:max KB以下にしてください。',
        'numeric' => ':attributeの値は:max以下にしてください。',
        'string' => ':attributeの文字数は:max文字以下にしてください。',
    ],
    'max_digits' => ':attributeの桁数は:max桁以下にしてください。',
    'mimes' => ':attributeには、次のタイプのファイルを指定してください: :values。',
    'mimetypes' => ':attributeには、次のタイプのファイルを指定してください: :values。',
    'min' => [
        'array' => ':attributeの項目数は:min個以上にしてください。',
        'file' => ':attributeのファイルサイズは:min KB以上にしてください。',
        'numeric' => ':attributeの値は:min以上にしてください。',
        'string' => ':attributeの文字数は:min文字以上にしてください。',
    ],
    'min_digits' => ':attributeは:min桁以上にしてください。',
    'missing' => ':attributeフィールドが存在してはいけません。',
    'missing_if' => ':otherが:valueの場合、:attributeフィールドが存在してはいけません。',
    'missing_unless' => ':otherが:valueでない限り、:attributeフィールドが存在してはいけません。',
    'missing_with' => ':valuesが存在する場合、:attributeフィールドが存在してはいけません。',
    'missing_with_all' => ':valuesが存在する場合、:attributeフィールドが存在してはいけません。',
    'multiple_of' => ':attributeは:valueの倍数でなければなりません。',
    'not_in' => '選択された:attributeは無効です。',
    'not_regex' => ':attributeの形式が無効です。',
    'numeric' => ':attributeには、数値を指定してください。',
    'password' => [
        'letters' => ':attributeには、少なくとも1文字を含める必要があります。',
        'mixed' => ':attributeには、少なくとも1つの大文字と1つの小文字を含める必要があります。',
        'numbers' => ':attributeには、少なくとも1つの数字を含める必要があります。',
        'symbols' => ':attributeには、少なくとも1つの記号を含める必要があります。',
        'uncompromised' => '指定された:attributeはデータ漏洩に含まれています。別の:attributeを選択してください。',
    ],
    'present' => ':attributeフィールドが存在している必要があります。',
    'present_if' => ':otherが:valueの場合、:attributeが存在している必要があります。',
    'present_unless' => ':otherが:valueでない限り、:attributeが存在している必要があります。',
    'present_with' => ':valuesが存在する場合、:attributeが存在している必要があります。',
    'present_with_all' => ':valuesが存在する場合、:attributeが存在している必要があります。',
    'prohibited' => ':attributeは禁止されています。',
    'prohibited_if' => ':otherが:valueの場合、:attributeは禁止されています。',
    'prohibited_unless' => ':otherが:valuesに含まれていない限り、:attributeは禁止されています。',
    'prohibits' => ':attributeフィールドは:otherの存在を禁止します。',
    'regex' => ':attributeの形式が無効です。',
    'required' => ':attributeは必須です。',
    'required_array_keys' => ':attributeには、:valuesのエントリが含まれている必要があります。',
    'required_if' => ':otherが:valueの場合、:attributeは必須です。',
    'required_if_accepted' => ':otherが承認されている場合、:attributeは必須です。',
    'required_if_declined' => ':otherが拒否されている場合、:attributeは必須です。',
    'required_unless' => ':otherが:valuesに含まれていない限り、:attributeは必須です。',
    'required_with' => ':valuesが存在する場合、:attributeは必須です。',
    'required_with_all' => ':valuesが存在する場合、:attributeは必須です。',
    'required_without' => ':valuesが存在しない場合、:attributeは必須です。',
    'required_without_all' => ':valuesのいずれも存在しない場合、:attributeは必須です。',
    'same' => ':attributeと:otherは一致している必要があります。',
    'size' => [
        'array' => ':attributeには:size個の項目を含める必要があります。',
        'file' => ':attributeのファイルサイズは:sizeキロバイトでなければなりません。',
        'numeric' => ':attributeは:sizeでなければなりません。',
        'string' => ':attributeの文字数は:size文字でなければなりません。',
    ],
    'starts_with' => ':attributeは次のいずれかで始まる必要があります: :values。',
    'string' => ':attributeは文字列でなければなりません。',
    'timezone' => ':attributeは有効なタイムゾーンでなければなりません。',
    'unique' => ':attributeはすでに存在しています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'uppercase' => ':attributeは大文字でなければなりません。',
    'url' => ':attributeは有効なURLでなければなりません。',
    'ulid' => ':attributeは有効なULIDでなければなりません。',
    'uuid' => ':attributeは有効なUUIDでなければなりません。',
    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション言語行
    |--------------------------------------------------------------------------
    |
    | "属性.ルール"の規約でキーを指定することでカスタムバリデーション
    | メッセージを定義できます。指定した属性ルールに対する特定の
    | カスタム言語行を手早く指定できます。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、例えば"email"の代わりに「メールアドレス」のように、
    | 読み手にフレンドリーな表現でプレースホルダーを置き換えるために指定する
    | 言語行です。これはメッセージをよりきれいに表示するために役に立ちます。
    |
    */

    'attributes' => include 'attributes.php',

];
