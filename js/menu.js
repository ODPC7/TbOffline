function change_style(id){
	document.getElementById(id).style.backgroundColor = "#ffffff";
	document.getElementById(id).style.color = "#e93f75";
	document.getElementById(id).style.borderBottom = "5px solid #e93f75";
	
	if (document.getElementById(id).id === "i")	{
		document.getElementById("ii").addEventListener("click", default_style("ii"));
		document.getElementById("iii").addEventListener("click", default_style("iii"));
		document.getElementById("iv").addEventListener("click", default_style("iv"));
		document.getElementById("v").addEventListener("click", default_style("v"));
		document.getElementById("vi").addEventListener("click", default_style("vi"));

		document.getElementById("service-menu").style.display="none";
		document.getElementById("network-menu").style.display="none";
		document.getElementById("about-menu").style.display="none";
	}

	if (document.getElementById(id).id === "ii")	{
		document.getElementById("i").addEventListener("click", default_style("i"));
		document.getElementById("iii").addEventListener("click", default_style("iii"));
		document.getElementById("iv").addEventListener("click", default_style("iv"));
		document.getElementById("v").addEventListener("click", default_style("v"));
		document.getElementById("vi").addEventListener("click", default_style("vi"));

		document.getElementById("service-menu").style.display="block";
		document.getElementById("network-menu").style.display="none";
		document.getElementById("about-menu").style.display="none";
	}

	if (document.getElementById(id).id === "iii")	{
		document.getElementById("i").addEventListener("click", default_style("i"));
		document.getElementById("ii").addEventListener("click", default_style("ii"));
		document.getElementById("iv").addEventListener("click", default_style("iv"));
		document.getElementById("v").addEventListener("click", default_style("v"));
		document.getElementById("vi").addEventListener("click", default_style("vi"));

		document.getElementById("service-menu").style.display="none";
		document.getElementById("network-menu").style.display="none";
		document.getElementById("about-menu").style.display="none";
	}

	if (document.getElementById(id).id === "iv")	{
		document.getElementById("i").addEventListener("click", default_style("i"));
		document.getElementById("ii").addEventListener("click", default_style("ii"));
		document.getElementById("iii").addEventListener("click", default_style("iii"));
		document.getElementById("v").addEventListener("click", default_style("v"));
		document.getElementById("vi").addEventListener("click", default_style("vi"));

		document.getElementById("service-menu").style.display="none";
		document.getElementById("network-menu").style.display="none";
		document.getElementById("about-menu").style.display="none";
	}

	if (document.getElementById(id).id === "v")	{
		document.getElementById("i").addEventListener("click", default_style("i"));
		document.getElementById("ii").addEventListener("click", default_style("ii"));
		document.getElementById("iii").addEventListener("click", default_style("iii"));
		document.getElementById("iv").addEventListener("click", default_style("iv"));
		document.getElementById("vi").addEventListener("click", default_style("vi"));

		document.getElementById("service-menu").style.display="none";
		document.getElementById("network-menu").style.display="block";
		document.getElementById("about-menu").style.display="none";
	}

	if (document.getElementById(id).id === "vi")	{
		document.getElementById("i").addEventListener("click", default_style("i"));
		document.getElementById("ii").addEventListener("click", default_style("ii"));
		document.getElementById("iii").addEventListener("click", default_style("iii"));
		document.getElementById("iv").addEventListener("click", default_style("iv"));
		document.getElementById("v").addEventListener("click", default_style("v"));

		document.getElementById("service-menu").style.display="none";
		document.getElementById("network-menu").style.display="none";
		document.getElementById("about-menu").style.display="block";
	}

}

function default_style(id){
	document.getElementById(id).style.backgroundColor = "#e93f75";
	document.getElementById(id).style.color = "#ffe4e1";
}

function show_sub_menu(id){
	if (document.getElementById(id).id === "service-menu")	{
		document.getElementById(id).style.display="block";
	}

	if (document.getElementById(id).id === "network-menu")	{
		document.getElementById(id).style.display="block";
	}

	if (document.getElementById(id).id === "about-menu")	{
		document.getElementById(id).style.display="block";
	}

}

function hide_sub_menu(id){
	if (document.getElementById(id).id === "service-menu")	{
		document.getElementById(id).style.display="none";
	}

	if (document.getElementById(id).id === "network-menu")	{
		document.getElementById(id).style.display="none";
	}

	if (document.getElementById(id).id === "about-menu")	{
		document.getElementById(id).style.display="none";
	}

}

function goPage(id){
	if (document.getElementById(id).id === "i")	{
		window.open("./index.php", "_self");
	}

	if (document.getElementById(id).id === "s-i")	{
		window.open("http://old.ddc.moph.go.th/complaint/index.php", "_blank");
	}

	if (document.getElementById(id).id === "s-ii")	{
		window.open("./journal/", "_blank");
	}

	if (document.getElementById(id).id === "s-iii")	{
		window.open("./others.php?group=จุลสาร", "_blank");
	}

	if (document.getElementById(id).id === "s-iv")	{
		window.open("./lab/result.php", "_blank");
	}

	if (document.getElementById(id).id === "s-v")	{
		window.open("./maintenance/index.php?act=showsv", "_blank");
	}

	if (document.getElementById(id).id === "s-vi")	{
		window.open("http://103.40.148.169/dpc6/index.php", "_blank");
	}

	if (document.getElementById(id).id === "s-vii")	{
		window.open("./itservice/index.php", "_blank");
	}

	if (document.getElementById(id).id === "iii")	{
		window.open("./index.php#data_center", "_self");
	}

	if (document.getElementById(id).id === "iv")	{
		window.open("./back_office/home.php", "_blank");
	}

	if (document.getElementById(id).id === "a-i")	{
		window.open("./aboutus.php#structure", "_blank");
	}

	if (document.getElementById(id).id === "a-ii")	{
		window.open("./aboutus.php#vision", "_blank");
	}

	if (document.getElementById(id).id === "a-iii")	{
		window.open("./aboutus.php#organizer", "_blank");
	}

	if (document.getElementById(id).id === "a-iv")	{
		window.open("./aboutus.php#location", "_blank");
	}

	if (document.getElementById(id).id === "a-v")	{
		window.open("./aboutus.php#support_land", "_blank");
	}

	if (document.getElementById(id).id === "n-i")	{
		window.open("http://www.kkpho.go.th/homes/", "_blank");
	}

	if (document.getElementById(id).id === "n-ii")	{
		window.open("http://mkho.moph.go.th/mko/", "_blank");
	}

	if (document.getElementById(id).id === "n-iii")	{
		window.open("http://sasuk101.net/", "_blank");
	}

	if (document.getElementById(id).id === "n-iv")	{
		window.open("http://203.157.186.15/", "_blank");
	}

	if (document.getElementById(id).id === "n-v")	{
		window.open("http://www.healtharea.net/", "_blank");
	}

	if (document.getElementById(id).id === "n-vi")	{
		window.open("http://www.r8way.com/r8way/index.php", "_blank");
	}

	if (document.getElementById(id).id === "n-vii")	{
		window.open("http://www.ddc.moph.go.th/index.php", "_blank");
	}

	if (document.getElementById(id).id === "n-viii")	{
		window.open("http://www.moph.go.th/", "_blank");
	}

}


function show_sub(id){
	if (document.getElementById(id).id === "hn1_sub")	{
		document.getElementById(id).style.display="block";
		document.getElementById("hn2_sub").style.display="none";
		document.getElementById("hn3_sub").style.display="none";
		document.getElementById("hn4_sub").style.display="none";
		document.getElementById("hn5_sub").style.display="none";
		document.getElementById("hn6_sub").style.display="none";
	}

	if (document.getElementById(id).id === "hn2_sub")	{
		document.getElementById(id).style.display="block";
		document.getElementById("hn1_sub").style.display="none";
		document.getElementById("hn3_sub").style.display="none";
		document.getElementById("hn4_sub").style.display="none";
		document.getElementById("hn5_sub").style.display="none";
		document.getElementById("hn6_sub").style.display="none";
	}

	if (document.getElementById(id).id === "hn3_sub")	{
		document.getElementById(id).style.display="block";
		document.getElementById("hn1_sub").style.display="none";
		document.getElementById("hn2_sub").style.display="none";
		document.getElementById("hn4_sub").style.display="none";
		document.getElementById("hn5_sub").style.display="none";
		document.getElementById("hn6_sub").style.display="none";
	}

	if (document.getElementById(id).id === "hn4_sub")	{
		document.getElementById(id).style.display="block";
		document.getElementById("hn1_sub").style.display="none";
		document.getElementById("hn2_sub").style.display="none";
		document.getElementById("hn3_sub").style.display="none";
		document.getElementById("hn5_sub").style.display="none";
		document.getElementById("hn6_sub").style.display="none";
	}

	if (document.getElementById(id).id === "hn5_sub")	{
		document.getElementById(id).style.display="block";
		document.getElementById("hn1_sub").style.display="none";
		document.getElementById("hn2_sub").style.display="none";
		document.getElementById("hn3_sub").style.display="none";
		document.getElementById("hn4_sub").style.display="none";
		document.getElementById("hn6_sub").style.display="none";
	}

	if (document.getElementById(id).id === "hn6_sub")	{
		document.getElementById(id).style.display="block";
		document.getElementById("hn1_sub").style.display="none";
		document.getElementById("hn2_sub").style.display="none";
		document.getElementById("hn3_sub").style.display="none";
		document.getElementById("hn4_sub").style.display="none";
		document.getElementById("hn5_sub").style.display="none";
	}

}