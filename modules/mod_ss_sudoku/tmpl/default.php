<?php
// No direct access
defined('_JEXEC') or die;
?>
<style>
    .moduletable > h1, .moduletable > h2, .moduletable > h3 {
        display: none;
    }

    .sudoku input {
        width: 100%;
        margin: 0;
        padding: 0;
        text-align: center;
    }
</style>

<script>
    // Module Sudoku .js
    SOLEIL.Sudoku = function (inputArr) {
        "use strict";
        // private
        var possiArr = [];

        /**
         * Remove an element form array
         * @param {Array} arr
         * @param elem
         * @returns {*}
         */
        var removeElem = function (arr, elem) {
            var index = arr.indexOf(elem);
            if (index > -1) {
                arr.splice(index, 1);
            }
            return arr;
        };

        /**
         * Return sum of filled numbers
         * @returns {number}
         */
        var totalResult = function () {
            var total = 0;
            for (var i = 0; i < inputArr.length; i++) {
                for (var j = 0; j < inputArr[i].length; j++) {
                    if (inputArr[i][j] !== null) {
                        total++;
                    }
                }
            }
            return total;
        };

        /**
         * Create a shadow array to assist calculating
         */
        var fillPossi = function () {
            for (var r = 0; r < inputArr.length; r++) {
                possiArr[r] = [];
                for (var c = 0; c < inputArr[r].length; c++) {
                    possiArr[r][c] = (inputArr[r][c] === null) ? [1, 2, 3, 4, 5, 6, 7, 8, 9] : null;
                }
            }
        };

        /**
         * Search possibilities of sudoku
         */
        var searchPossi = function () {
            var rr, cc, r, c, blocR, blocC;
            for (r = 0; r < possiArr.length; r++) {
                for (c = 0; c < possiArr[r].length; c++) {
                    if (possiArr[r][c] === null) {

                        // row 1x9
                        for (cc = 0; cc < possiArr[r].length; cc++) {
                            if (possiArr[r][cc] !== null) { // cell to resolve
                                possiArr[r][cc] = removeElem(possiArr[r][cc], inputArr[r][c]);
                            }
                        }

                        // column 9x1
                        for (rr = 0; rr < possiArr.length; rr++) {
                            if (possiArr[rr][c] !== null) { // cell to resolve
                                possiArr[rr][c] = removeElem(possiArr[rr][c], inputArr[r][c]);
                            }
                        }

                        // block 3x3
                        blocR = Math.floor(r / 3);
                        blocC = Math.floor(c / 3);
                        for (rr = 3 * blocR; rr < 3 * (blocR + 1); rr++) {
                            for (cc = 3 * blocC; cc < 3 * (blocC + 1); cc++) {
                                if (rr !== r && cc !== c && possiArr[rr][cc] !== null) { // cell to resolve
                                    possiArr[rr][cc] = removeElem(possiArr[rr][cc], inputArr[r][c]);
                                }
                            }
                        }
                    }
                }
            }
        };

        /**
         * Find the unique answer for one cell
         * @returns {boolean}
         */
        var fillResult = function () {
            var r, c, found = false;
            for (r = 0; r < possiArr.length; r++) {
                for (c = 0; c < possiArr[r].length; c++) {
                    if (possiArr[r][c] !== null && possiArr[r][c].length === 1) {
                        // unique answer
                        found = true;
                        inputArr[r][c] = possiArr[r][c][0];
                        possiArr[r][c] = null;
                    }
                }
            }
            return found;
        };

        // public
        return {
            Go: function () {
                // Init an show array to calculate possibilities
                fillPossi();

                // Recursive to find unique number
                while (totalResult() < 81) {
                    searchPossi();
                    if (fillResult() === false) {
                        alert('No found result');
                        inputArr = null;
                        break;
                    }
                }
                return inputArr;
            }
        };
    };

    // Controller Sudoku .js
    (function ($) {
        $(function () {
            'use strict';

            // Get filled numbers from html tables
            var getTableNums = function () {
                var inputArr = [[], [], [], [], [], [], [], [], []];
                var allowNums = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                $('.sudoku_cell').each(function () {
                    var data = $(this).data('val').split('-');
                    var val = $(this).val();
                    val = (val === '') ? null : parseInt(val);
                    if (val !== null && allowNums.indexOf(val) === -1) {
                        alert('Number allowed only between 0-9');
                        return null;
                    }
                    var r = parseInt(data[0]);
                    var c = parseInt(data[1]);

                    inputArr[r][c] = val;
                });

                return inputArr;
            };

            // Fill numbers to html tables
            var assignTableNums = function (solution) {
                $('.sudoku_cell').each(function () {
                    var data = $(this).data('val').split('-');
                    var r = parseInt(data[0]);
                    var c = parseInt(data[1]);

                    $(this).val(solution[r][c]);
                });
            };

            // Reset
            $('#sudoku-reset-btn').click(function () {
                $('.sudoku_cell').val(null);
            });

            // Start
            $('#sudoku-start-btn').click(function () {
                // Get numbers from HTML
                var inputArr = getTableNums();
                if(inputArr === null) return;

                // Call module Sudoku
                var sudoku = new SOLEIL.Sudoku(inputArr);
                var solution = sudoku.Go();
                if(solution === null) return;

                // Assign data to HTML
                assignTableNums(solution);
            });

            // Examples data
            $('#sudoku-exp-btn').click(function () {
                // random number
                var min = Math.ceil(0);
                var max = Math.floor(1);
                var num = Math.floor(Math.random() * (max - min + 1)) + min;
                var inputArr = [
                    [
                        [null, 7, 6, null, 1, null, null, 4, 3],
                        [null, null, null, 7, null, 2, 9, null, null],
                        [null, 9, null, null, null, 6, null, null, null],
                        [null, null, null, null, 6, 3, 2, null, 4],
                        [4, 6, null, null, null, null, null, 1, 9],
                        [1, null, 5, 4, 2, null, null, null, null],
                        [null, null, null, 2, null, null, null, 9, null],
                        [null, null, 4, 8, null, 7, null, null, 1],
                        [9, 1, null, null, 5, null, 7, 2, null]
                    ],
                    [
                        [1, null, null, null, 3, null, 5, 9, null],
                        [3, null, null, 5, null, null, null, 2, null],
                        [null, 5, null, 9, null, 2, 6, 3, 8],
                        [4, 3, null, null, null, null, null, null, null],
                        [null, null, null, 6, null, 1, null, null, null],
                        [null, null, null, null, null, null, null, 8, 7],
                        [6, 4, 7, 3, null, 8, null, 5, null],
                        [null, 1, null, null, null, 5, null, null, 9],
                        [null, 9, 2, null, 7, null, null, null, 3]
                    ]
                ];

                // Assign data to HTML
                assignTableNums(inputArr[num]);
            });

        })
    })(jQuery);

</script>

<div class="sudoku table-responsive">
    <table class="table table-bordered">
        <?php
        for ($row = 0; $row < 9; $row++) {
            echo '<tr>';
            for ($col = 0; $col < 9; $col++) {
                // Border style
                $styleTD = '';
                if ($row === 0) {
                    $styleTD .= 'border-top: 1px solid #000;';
                }
                if ($row % 3 === 2) {
                    $styleTD .= 'border-bottom: 1px solid #000;';
                }
                if ($col === 0) {
                    $styleTD .= 'border-left: 1px solid #000;';
                }
                if ($col % 3 === 2) {
                    $styleTD .= 'border-right: 1px solid #000;';
                }

                echo '<td style="' . $styleTD . '"">';
                echo '<input type="text" maxlength="1" data-val="' . $row . '-' . $col . '" class="sudoku_cell" autocomplete="false" />';
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>

    <button id="sudoku-reset-btn" class="btn btn-danger">Reset</button>
    <button id="sudoku-start-btn" class="btn btn-success">Search solution</button>
    <button id="sudoku-exp-btn" class="btn btn-info">Generate sudoku</button>
</div>
