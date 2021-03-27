<div class="virtual_keyboard">
    <div class="form-inline">
        <div class="form-group">
            <label for="language">Язык</label>
            <select id="language" name="language" class="form-control ml-1 mr-2 vk_language">
                <option value="russian">Русский</option>
                <option value="slavic">Церковнославянский</option>
                <option value="latin">Латинский</option>
                <option value="greek">Греческий</option>
                <option value="hebrew">Еврейский</option>
            </select>
        </div>
        <div class="form-group csl_font">
            <label for="font">Шрифт</label>
            <select id="font" name="font" class="form-control ml-1 vk_font">
                <option value="ponomar">Ponomar</option>
                <option value="fedorovsk">Fedorovsk</option>
                <option value="menaion">Menaion</option>
                <option value="monomakh">Monomakh</option>
                <option value="cathisma">Cathisma</option>
                <option value="oglavie">Oglavie</option>
                <option value="fira">FiraSlav</option>
                <option value="pochaevsk">Pochaevsk</option>
                <option value="triodion">Triodion</option>
                <option value="acathist">Acathist</option>
                <option value="shafarik">Shafarik</option>
                <option value="shafarik3">Shafarik3</option>
                <option value="pomorsky-dropcaps">Pomorsky</option>
                <option value="indiction-dropcaps">Indiction</option>
                <option value="vertograd-dropcaps">Vertograd</option>
            </select>
        </div>
    </div>
    <button type="button" class="btn btn-outline-dark vk_close"><i class="fas fa-times"></i></button>
    <hr />
    <div class="vk_keys russian">
        <?php
        ShowKeys(array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','І',
            'К','Л','М','Н','О','П','Р','С','Т','У','Ф',
            'Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Ѣ','Э','Ю','Я','Ѳ','Ѵ'));
        echo '<br />';
        ShowKeys(array('а','б','в','г','д','е','ё','ж','з','и','й','і',
            'к','л','м','н','о','п','р','с','т','у','ф',
            'х','ц','ч','ш','щ','ъ','ы','ь','ѣ','э','ю','я','ѳ','ѵ'));
        echo '<br />';
        ShowKeys(array('1','2','3','4','5','6','7','8','9','0',
            '.',',',':',';','-','–','!','?','(',')','’','«','»','*',mb_chr(0x301)/*акут*/));
        ?>
    </div>
    <div class="vk_keys slavic">
        <?php
        ShowKeys(array('А','Б','В','Г','Д','Е','Ж', mb_chr(0x405),'З','И','Й','І', mb_chr(0x407),
            'К','Л','М','Н','О', mb_chr(0x47A), mb_chr(0x460), mb_chr(0x47C),'П','Р','С','Т','У', mb_chr(0x478), mb_chr(0xA64A),'Ф',
            'Х', mb_chr(0x47E),'Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Ѣ','Ю', mb_chr(0xA656), mb_chr(0x466), mb_chr(0x46A), mb_chr(0x46E), mb_chr(0x470),'Ѳ','Ѵ', mb_chr(0x476),
            mb_chr(0x301)/*акут*/, mb_chr(0x300)/*гравис*/, mb_chr(0x302)/*циркумфлекс*/, mb_chr(0x486)/*придыхание*/, mb_chr(0x483)/*титло*/, mb_chr(0x482)/*тысяча*/));
        echo '<br />';
        ShowKeys(array('а','б','в','г','д','е', mb_chr(0x454),'ж', mb_chr(0x455),'з','и','й','і', mb_chr(0x457),
            'к','л','м','н','о', mb_chr(0x47B), mb_chr(0x461), mb_chr(0x47D),'п','р','с','т','у', mb_chr(0x479), mb_chr(0xA64B),'ф',
            'х', mb_chr(0x47F),'ц','ч','ш','щ','ъ','ы','ь','ѣ','ю', mb_chr(0xA657), mb_chr(0x467), mb_chr(0x46B), mb_chr(0x46F), mb_chr(0x471),'ѳ','ѵ', mb_chr(0x477),
            mb_chr(0x2DE3)/*д)*/, mb_chr(0x2DE4)/*ж)*/, mb_chr(0x2DE5)/*з)*/, mb_chr(0x2DE8)/*м)*/, mb_chr(0x2DEA)/*о)*/, mb_chr(0x2DED)/*с)*/, mb_chr(0x2DEE)/*т)*/, mb_chr(0x2DEF)/*х)*/, mb_chr(0x487)/*буквенное титло*/));
        echo '<br />';
        ShowKeys(array('.',',',':',';','-','–','!','?','(',')','’'));
        ?>
    </div>
    <div class="vk_keys latin">
        <?php
        ShowKeys(array('A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z','Ā','Ē','Ī','Ō','Ū','Ȳ','Ă','Ĕ','Ĭ','Ŏ','Ŭ','Y̆'));
        echo '<br />';
        ShowKeys(array('a','b','c','d','e','f','g','h','i','j','k','l','m',
            'n','o','p','q','r','s','t','u','v','w','x','y','z','ā','ē','ī','ō','ū','ȳ','ă','ĕ','ĭ','ŏ','ŭ','y̆'));
        echo '<br />';
        ShowKeys(array('1','2','3','4','5','6','7','8','9','0',
            '.',',',':',';',mb_chr(0xB7),'-','–','—','!','¡','?','¿','(',')','‘','’','“','”','«','»','*'));
        ?>
    </div>
    <div class="vk_keys greek">
        <?php
        ShowKeys(array('Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ',
            'Ν','Ξ','Ο','Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω','Ϊ','Ϋ','Ά','Έ','Ή','Ί','Ό','Ύ','Ώ',mb_chr(0x300), mb_chr(0x301), mb_chr(0x313), mb_chr(0x314), mb_chr(0x342), mb_chr(0x343), mb_chr(0x344), mb_chr(0x345)));
        echo '<br />';
        ShowKeys(array('α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ',
            'ν','ξ','ο','π','ρ','ς','σ','τ','υ','φ','χ','ψ','ω','ϊ','ϋ','ά','έ','ή','ί','ό','ύ','ώ','ΐ','ΰ'));
        echo '<br />';
        ShowKeys(array('1','2','3','4','5','6','7','8','9','0', mb_chr(0x374), mb_chr(0x375),'.',',',':',';', mb_chr(0xB7), mb_chr(0x387),'-','–','!','(',')','«','»','*'));
        ?>
    </div>
    <div class="vk_keys hebrew">
        <?php
        ShowKeys(array(mb_chr(0x5D0), mb_chr(0x5D1), mb_chr(0x5D2), mb_chr(0x5D3), mb_chr(0x5D4), mb_chr(0x5D5), mb_chr(0x5D6), mb_chr(0x5D7), mb_chr(0x5D8), mb_chr(0x5D9), mb_chr(0x5DA), mb_chr(0x5DB), mb_chr(0x5DC), mb_chr(0x5DD), mb_chr(0x5DE), mb_chr(0x5DF),
            mb_chr(0x5E0), mb_chr(0x5E1), mb_chr(0x5E2), mb_chr(0x5E3), mb_chr(0x5E4), mb_chr(0x5E5), mb_chr(0x5E6), mb_chr(0x5E7), mb_chr(0x5E8), mb_chr(0x5E9), mb_chr(0x5EA),
            mb_chr(0x5B0), mb_chr(0x5B1), mb_chr(0x5B2), mb_chr(0x5B3), mb_chr(0x5B4), mb_chr(0x5B5), mb_chr(0x5B6), mb_chr(0x5B7), mb_chr(0x5B8), mb_chr(0x5B9), mb_chr(0x5BB), mb_chr(0x5BC), mb_chr(0x5BD), mb_chr(0x5BE), mb_chr(0x5BF)));
        echo '<br />';
        ShowKeys(array('1','2','3','4','5','6','7','8','9','0','.',',',':',';','-','–','!','?','(',')','\'','"','*',mb_chr(0x5F0),mb_chr(0x5F1),mb_chr(0x5F2),mb_chr(0x5F3),mb_chr(0x5F4),
            mb_chr(0x591),mb_chr(0x592),mb_chr(0x593),mb_chr(0x594),mb_chr(0x595),mb_chr(0x596),mb_chr(0x597),mb_chr(0x598),mb_chr(0x599),mb_chr(0x59A),mb_chr(0x59B),mb_chr(0x59C),mb_chr(0x59D),mb_chr(0x59E),mb_chr(0x59F),
            mb_chr(0x5A0),mb_chr(0x5A1),mb_chr(0x5A3),mb_chr(0x5A4),mb_chr(0x5A5),mb_chr(0x5A6),mb_chr(0x5A7),mb_chr(0x5A8),mb_chr(0x5A9),mb_chr(0x5AA),mb_chr(0x5AB),mb_chr(0x5AC),mb_chr(0x5AD),mb_chr(0x5AE),mb_chr(0x5AF),
            mb_chr(0x5C0),mb_chr(0x5C1),mb_chr(0x5C2),mb_chr(0x5C3),mb_chr(0x5C4)));
        ?>
    </div>
</div>