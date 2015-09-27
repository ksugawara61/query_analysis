<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>検索クエリ分析ツール</title>
		<link rel="stylesheet" href="css/style.css">
		<script type="text/javascript" src="d3/d3.v3.js"></script>
		<style type="text/css">
		.axis path,
		.axis line {
			fill: none;
			stroke: black;
			shape-rendering: crispEdges;
		}
		
		.axis test {
			font-family: sans-serif;
			font-size: 11px;
		}
		</style>
	</head>
	<body>
		<?php
		$start = $_GET{'year1'} . "-" . $_GET{'month1'};
		$end = $_GET{'year2'} . "-" . $_GET{'month2'};
//		$year1 = $_GET{'year1'};
//		$year2 = $_GET{'year2'};
//		$month1 = $_GET{'month1'};
//		$month2 = $_GET{'month2'};
		$keyword = $_GET{'keyword'};
		$dataset = array();

		if (!is_null($keyword)){
			// getの値をもとにデータセットarrayを作成
			for ($i = strtotime($start); $i <= strtotime($end); $i = strtotime(date("Y-m", $i) . " +1 month")) {
				//		for ($i = $month1; $i <= $month2; $i++) {

				// csvファイルのオープン
				$name = "./log/" . date("Y-m", $i) . ".csv";
				//			$name = "./log/" . $year1 . "-" . sprintf("%02d", $i) . ".csv";
				$fp = fopen($name, "r");

				$cnt = 0;
				while($data = fgetcsv($fp)) {
					if (strstr($data[0], $keyword) !== FALSE) {
						$cnt += $data[1];
					}
				}
				array_push($dataset, $cnt);
				fclose($fp);
			}
		}
		?>

		<div id="submit">
			<h1>検索クエリ分析ツール</h1>
			<form method="get" action="index.php">
				<p>キーワード
					<input id="keyword" name="keyword" type="text" value="<?php echo $keyword; ?>">
					を含む検索クエリの数
				</p>
				
				<p>期間
				<select class="select-box" name="year1">
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select>
				<select class="select-box" name="month1">
					<option value="1">01</option>
					<option value="2">02</option>
					<option value="3">03</option>
					<option value="4">04</option>
					<option value="5">05</option>
					<option value="6">06</option>
					<option value="7">07</option>
					<option value="8">08</option>
					<option value="9">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				〜
				<select class="select-box" name="year2">
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select>
				<select class="select-box" name="month2">
					<option value="1">01</option>
					<option value="2">02</option>
					<option value="3">03</option>
					<option value="4">04</option>
					<option value="5">05</option>
					<option value="6">06</option>
					<option value="7">07</option>
					<option value="8">08</option>
					<option value="9">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				<input type="submit" value="送信">
				</p>
			</form>
				<p>入力キーワード：<b><?php echo $keyword; ?></b></p>
				<p>入力期間：<b><?php echo $start; ?>〜<?php echo $end; ?></b></p>
				<p>検索クエリ数：<?php echo json_encode($dataset); ?></p>
		</div>

		<script type="text/javascript">
		// グラフの縦幅と横幅の設定
		var w = 800;
		var h = 250;
		var padding = 20;

		/*var dataset = [
			5, 10, 10, 20, 100, 100,
			10000, 20000, 2000, 20, 5, 3
		];*/
		var dataset = <?php echo json_encode($dataset); ?>;

		var xScale = d3.scale.ordinal()
			.domain(d3.range(dataset.length))
			.rangeRoundBands([padding, w], 0.05);

		var yScale = d3.scale.linear()
			.domain([0, d3.max(dataset)])
			.range([0, h - padding]);
		
		//Create SVG element
		var svg = d3.select("body")
			.append("svg")
			.attr("width", w)
			.attr("height", h);

		//Create bars
		svg.selectAll("rect")
			.data(dataset)
			.enter()
			.append("rect")
			.attr("x", function(d, i) {
			   	return xScale(i);
			})
			.attr("y", function(d) {
			   	return h - yScale(d) - padding;
			})
			.attr("width", xScale.rangeBand())
			.attr("height", function(d) {
			   	return yScale(d);
			})
			.attr("fill", function(d) {
				return "rgb(0, 0, " + (d * 10) + ")";
			});

		//Create labels
		svg.selectAll("text")
			.data(dataset)
			.enter()
			.append("text")
			.text(function(d) {
			   	return d;
			})
			.attr("text-anchor", "middle")
			.attr("x", function(d, i) {
			   	return xScale(i) + xScale.rangeBand() / 2;
			})
			.attr("y", function(d) {
			   	return h - yScale(d) + 14;
			})
			.attr("font-family", "sans-serif")
			.attr("font-size", "11px")
			.attr("fill", "white");

		// X軸の作成
		var xAxis = d3.svg.axis()
			.scale(xScale)
			.orient("bottom");
//			.tickFormat(function(d, i) {
//				return d;
//			});
		svg.append("g")
			.attr("class", "axis")
			.attr("transform", "translate(0," + (h - padding) + ")")
			.call(xAxis);

		// Y軸の作成
//		var yAxis = d3.svg.axis()
//			.scale(yScale)
//			.orient("left")
//			.ticks(5);  // 目盛りの数を設定
//		svg.append("g")
//			.attr("class", "axis")
//			.attr("transform", "translate(" + padding + ",0)")
//			.call(yAxis);
  		</script>
	</body>
</html>
