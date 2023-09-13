var baseUrl = "https://starfoods.ir";

var i, tabContent, tablinks;

function discountTab(event,  tabId){
    tabContent = document.getElementsByClassName("discount-tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
      }

    tablinks = document.getElementsByClassName("discount-tab-item");
    for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace("activeTab", "");
    }

    document.getElementById(tabId).style.display = "block";
    event.currentTarget.className += "activeTab";

}

