<?php

namespace App\Service\Agent\TextEditor\Trait;

trait TextEditorAgentServicePrivateFunctionProviderTrait
{
    private function getPrompt($message): string
    {
        return $message . " -> cümlesini herhangi bir yazım yanlışı varsa türkçe dil bilgisine uygun olarak düzeltir misin ? Yeni oluşan cümlede anlam bozukluğu olmamalı ve cümlenein eski anlamı korunmalı. Cümle içinde anlam olarak farklı kelimeler türetmemelisin. Eğer kelime yanlış yazılmışsa. Kök değerine göre bir düzenleme yapmalısın. Ayrıca cevap olarak sadece düzenlenen metni geriye döndür.";
    }
}
