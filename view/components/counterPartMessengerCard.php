            <?php
            if (!empty($counterpart[0])) { ?>
                <h2>User</h2>
                <p class="counterpartProfileImg"><img src="<?= $counterpart[0]->profile_picture ?>" alt=""></p>
                <p><strong> Name: </strong><?= $counterpart[0]->first_name . " " . $counterpart[0]->last_name ?></p>
                <p><strong> Email:</strong> <?= $counterpart[0]->email ?></p>
                <p><strong> Phone number:</strong> <?= $counterpart[0]->phone_number ?></p>
                <p><strong> Title:</strong> <?= $counterpart[0]->user_bio == null ? "none" : $counterpart[0]->user_bio ?></p>
                <img class="counterpartCompanyLogo" src="<?= $counterpart[0]->logo_img ?>" alt="">
                <p><strong> Company:</strong> <?= $counterpart[0]->name == null ? "none" : $counterpart[0]->name ?></p>
                <p><strong> Address:</strong> <?= $counterpart[0]->company_address == null ? "none" : $counterpart[0]->company_address ?></p>
                <p><strong> Company Email:</strong> <?= $counterpart[0]->email1 == null ? "none" : $counterpart[0]->email1 ?></p>
                <p><strong> Website:</strong> <?= $counterpart[0]->website_address == null ? "none" : $counterpart[0]->website_address ?></p>
                <p><strong> Office number: </strong><?= $counterpart[0]->phone_number1 == null ? "none" : $counterpart[0]->phone_number1 ?></p>
            <?php

            } ?>