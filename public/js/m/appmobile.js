function setFocus(){var t=document.getElementById("InputBarCode");t.focus(),t.onblur=function(){setTimeout(function(){t.focus()})}}function setPasteInputBarCode(){setTimeout(function(){document.getElementById("formInputBarCode").submit()},1)}