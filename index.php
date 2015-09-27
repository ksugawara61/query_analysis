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
		<div id="submit">
			<h1>検索クエリ分析ツール</h1>
			<form method="get" action="index.html">
				<p>キーワード
					<input id="keyword" name="keyword" type="text">
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
		</div>

		<script type="text/javascript">
		// グラフの縦幅と横幅の設定
		var w = 600;
		var h = 250;
		var padding = 20;

		var dataset = [
			5, 10, 10, 20, 100, 100,
			10000, 20000, 2000, 20, 5, 3
		];

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
		svg.append("g")
			.attr("class", "axis")
			.attr("transform", "translate(0," + (h - padding) + ")")
//			.attr("transform", "translate(0," + (h - 1) + ")")
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