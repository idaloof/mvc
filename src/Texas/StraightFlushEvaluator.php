<?php

/**
 * This class is for evaluating if a hand has a straight flush
 */

namespace App\Texas;

use App\Texas\StraightEvaluator;
use App\Texas\FlushEvaluator;

class StraightFlushEvaluator implements EvaluatorInterface
{
    /**
     * @var StraightEvaluator   $straightEvaluator  Class evaluating hand for straight
     * @var FlushEvaluator      $flushEvaluator     Class evaluating hand for flush
     */

    private StraightEvaluator   $straightEvaluator;
    private FlushEvaluator      $flushEvaluator;

    /**
     * Class constructor
     *
     * @param StraightEvaluator $straight   Class evaluating hand for straight
     * @param FlushEvaluator    $flush      Class evaluating hand for flush
     */
    public function __construct(StraightEvaluator $straight, FlushEvaluator $flush)
    {
        $this->straightEvaluator = $straight;
        $this->flushEvaluator = $flush;
    }

    /**
     * Returns straight flush if hand has it or empty string if not.
     *
     * @param array<string> $suits     Suits of the player's cards.
     * @param array<string> $values    Values of the player's cards.
     * @param array<string> $ranks     Ranks of the player's cards.
     *
     * @return string               "Straight Flush" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        if (in_array("14", $values) && in_array("13", $values)) {
            return "";
        }

        if ($this->straightEvaluator->evaluateHand($suits, $values, $ranks)
            && $this->flushEvaluator->evaluateHand($suits, $values, $ranks)) {
            return "Straight Flush";
        }

        return "";
    }
}
