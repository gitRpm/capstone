
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
?>
<script src='/js/Chart.js-master/Chart.js'></script>
<script src='Dashboard/dashboardJs.js'></script>
<div class='mainContent' style='height:500px'>
    <div class='charts'>
        <div class='chartWrap'>
            <h2>Individual Stats</h2>
            <canvas class='chart' id='barChart' width='600' height='400'></canvas>
            <div class="chart-description">Individual task statistics for the past 30 days.</div>
        </div>
        <div class='chartWrap'>
            <h2>All Stats</h2>
            <div class='index'>
                <div class="indexWrapper">
                    Complete
                    <div class="percentage" id="complete"></div>
                </div>
                <div class="indexWrapper">
                    Incomplete
                    <div class="percentage" id="incomplete"></div>
                </div>
                <div class="indexWrapper">
                    Past Due
                    <div class="percentage" id="pastDue"></div>
                </div>
            </div>
            <canvas class='chart' id='pieChart' width='600' height='400'></canvas>
            <div class="chart-description">All task statistics for the past 30 days.</div>
        </div>
    </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT']."/../util/footer/footer.php";


