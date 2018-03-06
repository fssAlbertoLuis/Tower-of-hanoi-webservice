<?php
/*
 * This file is part of the Tower-of-hanoi-webservice project.
 *
 * (c) 2018 Luis Alberto <albertoluis0108@gmail.com>
 * https://github.com/fssAlbertoLuis/ng2-HanoiTower
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

header('Access-Control-Allow-Origin: http://localhost', false);

class Hanoi {
    private $movements,
            $n_movements,
            $discs;

    public function __construct($discs) {
        $this->discs = $discs;
        $this->movements = [];
        $this->n_movements = 0;
    }

    function move($O, $D)
    {
        $this->movements[] = [
            'from' => $O,
            'to' => $D
        ];
        $this->n_movements++;
    }
        
    function hanoi($n, $O, $D, $T)
    {
        if ($n > 0) {
            $this->hanoi($n -1, $O, $T, $D);
            $this->move($O, $D);
            $this->hanoi($n -1, $T, $D, $O);
        }
    }

    public function calculate() 
    {
        $this->hanoi($this->discs, 1, 3, 2);
    }

    public function getMovements()
    {
        return [
            'movements' => $this->movements,
            'n_movements' => $this->n_movements
        ];
    }
}


if (!empty($_GET['discs']) && in_array($_GET['discs'], [3,4,5,6,7,8,9,10])) {
    $hanoi = new Hanoi($_GET['discs']);
    $hanoi->calculate();
    echo json_encode($hanoi->getMovements());
    die();
}

echo json_encode(['error' => 'Does\'t have discs...']);
die();