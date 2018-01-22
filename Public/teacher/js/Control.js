window.onload = function() {
	var btn = document.getElementById('btn-del');
	btn.addEventListener("click", function() {
		var checkboxs = document.getElementById("tbList").getElementsByTagName('input');
		console.log(checkboxs.length);
		var checkedNumber = 0;
		for(var i = 0; i < checkboxs.length; i++) {
			console.log(checkboxs[i].checked);
			if(checkboxs[i].checked) {
				checkedNumber = checkedNumber + 1;
			} else {
				continue;
			}
		}
		console.log(checkedNumber)
		if(checkedNumber == 0) {
			btn.setAttribute("data-target", "#notselect")
		} else {
			btn.setAttribute("data-target", "#delete-more");
		}
	});
	//全选、取消全选
	var selectedRow = 0;
	var checkArr = document.getElementById("tbList").getElementsByTagName("input");
	var checkArrLen = checkArr.length;
	var SelectAll = document.getElementById("selectAll");
	SelectAll.addEventListener("click", function() {
		//全选
		if(SelectAll.checked == true) {
			selectedRow = checkArrLen;
			console.log(selectedRow);
			for(var i = 0; i < checkArrLen; i++) {
				checkArr[i].checked = true;
			}
		}
		//取消全选
		else {
			selectedRow = 0;
			console.log(selectedRow);
			for(var j = 0; j < checkArrLen; j++) {
				checkArr[j].checked = false;
			}
		}
		//当逐行选择所有数据行后，全选框自动选择，当在全选状态下，有任何数据行被取消选择时，全选框自动取消选择
	});
	for(var i = 0; i < checkArrLen; i++) {
		checkArr[i].addEventListener("click", function() {
			var thisRow = this.parentNode.parentNode;
			console.log(thisRow);
			//点击之后如果该复选框checked状态为false，则selectRow减1
			if(this.checked == false) {
				thisRow.removeAttribute("class", "active");
				selectedRow = selectedRow - 1;
			}
			//点击之后如果该复选框checked状态为true，则selectRow加1
			else {
				thisRow.setAttribute("class", "active"); //添加active css类
				selectedRow = selectedRow + 1;
			}
			//当selectRow与tbody中的复选框数量一致时，全选复选框被选中吗
			if(selectedRow == checkArrLen) {
				SelectAll.checked = true;
			} else {
				SelectAll.checked = false;
			}
		});
	}
}