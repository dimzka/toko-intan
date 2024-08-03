<?php

function getCandidate1Itemsets($transactions) {
    $candidate1Itemsets = [];
    foreach ($transactions as $transaction) {
        foreach ($transaction as $item) {
            if (!isset($candidate1Itemsets[$item])) {
                $candidate1Itemsets[$item] = 1;
            } else {
                $candidate1Itemsets[$item]++;
            }
        }
    }
    return $candidate1Itemsets;
}

function getFrequentItemsets($candidateItemsets, $minSupport) {
    $frequentItemsets = [];
    foreach ($candidateItemsets as $itemset => $count) {
        if ($count >= $minSupport) {
            $frequentItemsets[$itemset] = $count;
        }
    }
    return $frequentItemsets;
}

function generateCandidates($frequentItemsets, $k) {
    $candidates = [];
    $keys = array_keys($frequentItemsets);
    for ($i = 0; $i < count($keys); $i++) {
        for ($j = $i + 1; $j < count($keys); $j++) {
            $itemset1 = explode(' ', $keys[$i]);
            $itemset2 = explode(' ', $keys[$j]);
            sort($itemset1);
            sort($itemset2);
            if (array_slice($itemset1, 0, $k - 2) == array_slice($itemset2, 0, $k - 2)) {
                $candidate = array_unique(array_merge($itemset1, $itemset2));
                sort($candidate);
                $candidates[implode(' ', $candidate)] = 0;
            }
        }
    }
    return $candidates;
}

function countSupport($transactions, $candidates) {
    foreach ($transactions as $transaction) {
        $transactionItems = explode(' ', implode(' ', $transaction));
        foreach ($candidates as $candidate => $count) {
            $candidateItems = explode(' ', $candidate);
            if (count(array_intersect($transactionItems, $candidateItems)) == count($candidateItems)) {
                $candidates[$candidate]++;
            }
        }
    }
    return $candidates;
}

function apriori($transactions, $minSupport) {
    $candidate1Itemsets = getCandidate1Itemsets($transactions);
    $frequentItemsets = getFrequentItemsets($candidate1Itemsets, $minSupport);
    $frequentItemsets2 = [];

    $k = 2;
    while (!empty($frequentItemsets)) {
        $candidates = generateCandidates($frequentItemsets, $k);
        $candidates = countSupport($transactions, $candidates);
        $frequentItemsets = getFrequentItemsets($candidates, $minSupport);
        $frequentItemsets2 = array_merge($frequentItemsets2, $frequentItemsets);
        $k++;
    }

    return $frequentItemsets2;
}

