<?php if ($runtime['active']) : ?>

    <div
        style="
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #111;
        color: #0f0;
        padding: 8px 12px;
        font-size: 12px;
        font-family: monospace;
    ">

        Runtime ACTIVE

        |

        Package:
        <?= esc($runtime['package']) ?>

        |

        Competition:
        <?= esc($runtime['title']) ?>

        |

        ENV:
        <?= esc(ENVIRONMENT) ?>

    </div>

<?php else : ?>

    <div
        style="
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #400;
        color: #fff;
        padding: 8px 12px;
        font-size: 12px;
        font-family: monospace;
    ">

        Runtime INACTIVE

    </div>

<?php endif; ?>