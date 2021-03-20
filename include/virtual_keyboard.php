<?php
function ShowKeys($arr_param) {
    if(is_array($arr_param)) {
        foreach ($arr_param as $key) {
            echo $key;
        }
    }
}
?>
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
            <select id="font" name="font" class="form-control ml-1">
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
            '.',',',':',';','-','–','!','?','(',')','’','«','»','*'));
        ?>
    </div>
    <div class="vk_keys slavic">
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
            '.',',',':',';','-','–','!','?','(',')','’','«','»','*'));
        ?>
    </div>
    <div class="vk_keys latin">
        <?php
        ShowKeys(array('A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'));
        echo '<br />';
        ShowKeys(array('a','b','c','d','e','f','g','h','i','j','k','l','m',
            'n','o','p','q','r','s','t','u','v','w','x','y','z'));
        echo '<br />';
        ShowKeys(array('1','2','3','4','5','6','7','8','9','0',
            '.',',',':',';',mb_chr(0xB7),'-','–','—','!','¡','?','¿','(',')','‘','’','“','”','«','»','*'));
        echo '<br />';
        ShowKeys(array('Ā','Ē','Ī','Ō','Ū','Ȳ','ā','ē','ī','ō','ū','ȳ'));
        echo '<br />';
        ShowKeys(array('Ă','Ĕ','Ĭ','Ŏ','Ŭ','Y̆','ă','ĕ','ĭ','ŏ','ŭ','y̆'));
        ?>
    </div>
    <div class="vk_keys greek">
        <?php
        ShowKeys(array('Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ',
            'Ν','Ξ','Ο','Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω'));
        echo '<br />';
        ShowKeys(array('α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ',
            'ν','ξ','ο','π','ρ','ς','σ','τ','υ','φ','χ','ψ','ω'));
        echo '<br />';
        ShowKeys(array('1','2','3','4','5','6','7','8','9','0', mb_chr(0x374), mb_chr(0x375),'.',',',':',';', mb_chr(0xB7), mb_chr(0x387),'-','–','!','(',')','«','»','*'));
        echo '<br />';
        ShowKeys(array(mb_chr(0x300), mb_chr(0x301), mb_chr(0x313), mb_chr(0x314), mb_chr(0x342), mb_chr(0x343), mb_chr(0x344), mb_chr(0x345)));
        ?>
    </div>
    <div class="vk_keys hebrew">
        <?php
        ShowKeys(array(mb_chr(0x5D0), mb_chr(0x5D1), mb_chr(0x5D2), mb_chr(0x5D3), mb_chr(0x5D4), mb_chr(0x5D5), mb_chr(0x5D6), mb_chr(0x5D7), mb_chr(0x5D8), mb_chr(0x5D9), mb_chr(0x5DA), mb_chr(0x5DB), mb_chr(0x5DC), mb_chr(0x5DD), mb_chr(0x5DE), mb_chr(0x5DF),
            mb_chr(0x5E0), mb_chr(0x5E1), mb_chr(0x5E2), mb_chr(0x5E3), mb_chr(0x5E4), mb_chr(0x5E5), mb_chr(0x5E6), mb_chr(0x5E7), mb_chr(0x5E8), mb_chr(0x5E9), mb_chr(0x5EA)));
        echo '<br />';
        ShowKeys(array('1','2','3','4','5','6','7','8','9','0','.',',',':',';','-','–','!','?','(',')','\'','"','*'));
        echo '<br />';
        ShowKeys(array(mb_chr(0x5B0), mb_chr(0x5B1), mb_chr(0x5B2), mb_chr(0x5B3), mb_chr(0x5B4), mb_chr(0x5B5), mb_chr(0x5B6), mb_chr(0x5B7), mb_chr(0x5B8), mb_chr(0x5B9), mb_chr(0x5BB), mb_chr(0x5BC), mb_chr(0x5BD), mb_chr(0x5BE), mb_chr(0x5BF)));
        echo '<br />';
        ShowKeys(array(mb_chr(0x5F0),mb_chr(0x5F1),mb_chr(0x5F2),mb_chr(0x5F3),mb_chr(0x5F4),
            mb_chr(0x591),mb_chr(0x592),mb_chr(0x593),mb_chr(0x594),mb_chr(0x595),mb_chr(0x596),mb_chr(0x597),mb_chr(0x598),mb_chr(0x599),mb_chr(0x59A),mb_chr(0x59B),mb_chr(0x59C),mb_chr(0x59D),mb_chr(0x59E),mb_chr(0x59F),
            mb_chr(0x5A0),mb_chr(0x5A1),mb_chr(0x5A3),mb_chr(0x5A4),mb_chr(0x5A5),mb_chr(0x5A6),mb_chr(0x5A7),mb_chr(0x5A8),mb_chr(0x5A9),mb_chr(0x5AA),mb_chr(0x5AB),mb_chr(0x5AC),mb_chr(0x5AD),mb_chr(0x5AE),mb_chr(0x5AF),
            mb_chr(0x5C0),mb_chr(0x5C1),mb_chr(0x5C2),mb_chr(0x5C3),mb_chr(0x5C4)));
        echo '<br />';
        ShowKeys(array(mb_chr(0xFB1D)/*I.*/,mb_chr(0xFB1E),mb_chr(0xFB1F)/*Ai*/,mb_chr(0xFB20),mb_chr(0xFB21),mb_chr(0xFB22),mb_chr(0xFB23),mb_chr(0xFB24),mb_chr(0xFB25),mb_chr(0xFB26),mb_chr(0xFB27),mb_chr(0xFB28),mb_chr(0xFB29),mb_chr(0xFB2A),mb_chr(0xFB2B)/*.S*/,mb_chr(0xFB2C),mb_chr(0xFB2D),mb_chr(0xFB2E)/*A_*/,mb_chr(0xFB2F)/*O*/,
            mb_chr(0xFB30),mb_chr(0xFB31),mb_chr(0xFB32),mb_chr(0xFB33),mb_chr(0xFB34),mb_chr(0xFB35)/*U.*/,mb_chr(0xFB36),mb_chr(0xFB38),mb_chr(0xFB39),mb_chr(0xFB3A),mb_chr(0xFB3B)/*K.*/,mb_chr(0xFB3C),mb_chr(0xFB3E),
            mb_chr(0xFB40),mb_chr(0xFB41),mb_chr(0xFB43),mb_chr(0xFB44)/*P*/,mb_chr(0xFB46),mb_chr(0xFB47),mb_chr(0xFB48),mb_chr(0xFB49),mb_chr(0xFB4A)/*T.*/,mb_chr(0xFB4B),mb_chr(0xFB4C)/*V_*/,mb_chr(0xFB4D)/*X_*/,mb_chr(0xFB4E)/*F_*/,mb_chr(0xFB4F)));
        ?>
    </div>
</div>