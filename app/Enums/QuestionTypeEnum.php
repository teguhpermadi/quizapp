<?php

namespace App\Enums;

enum QuestionTypeEnum: string
{
    case MULTIPLE_ANSWER = 'multiple answer';
    case MULTIPLE_CHOICE = 'multiple choice';
    case SHORT_ANSWER = 'short answer';
    case ESSAY = 'essay';
    case TRUE_FALSE = 'true false';
    case MATCHING = 'matching';
    case CALCULATE = 'calculate';
}
