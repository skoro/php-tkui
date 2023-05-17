<?php

namespace Tkui;

enum WMState: string
{
    case NORMAL = 'normal';

    case ICONIC = 'iconic';

    case WITHDRAWN = 'withdrawn';

    case ICON = 'icon';

    case ZOOMED = 'zoomed';
}
