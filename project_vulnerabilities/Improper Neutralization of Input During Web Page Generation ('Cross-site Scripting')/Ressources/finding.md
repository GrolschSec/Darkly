# Improper Neutralization of Input During Web Page Generation ('Cross-site Scripting')

## Description

Cross-site scripting (XSS) is a vulnerability that allows an attacker to inject malicious code (commonly JavaScript) into web pages viewed by other users. This can lead to information theft, content manipulation, or unauthorized actions on behalf of the victim.

### Stored XSS

Stored XSS, also known as Persistent XSS, occurs when the malicious script is stored permanently on the server (e.g., in a database) and is executed whenever the data is retrieved and displayed on the website. This makes it particularly dangerous as it affects all users who view the vulnerable page.

### Evidence of Vulnerability

The `Darkly` web application contains poor input validation in its feedback form. The following JavaScript is responsible for basic input validation:

```javascript
function validate_required(field,alerttxt) {
  with (field) {
    if (value==null || value=="") {
      alert(alerttxt);
      return false;
    } else {
      return true;
    }
  }
}

function validate_form(thisform) {
  with (thisform) {
    if (validate_required(txtName, "Name can not be empty.") == false) {
      txtName.focus();
      return false;
    }
    if (validate_required(mtxMessage, "Message can not be empty.") == false) {
      mtxMessage.focus();
      return false;
    }
  }
}
```

Issues with this code:

Input validation is weak and focuses only on checking if fields are empty.
The script references `mtxMessage`, while the actual field name is `mtxtMessage`, causing the validation to fail.

### Exploitation

An attacker can bypass input validation and inject a payload such as:

```html
<img src="invalid.jpg" onerror="alert('XSS')"/>
```

This payload will execute whenever a user views the page containing the injected script.