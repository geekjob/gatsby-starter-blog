---
title: "Convert Blob to Base64 in JS"
date: "2019-01-03T23:33:29.00Z"
description: ""
---

```js
const blob2base64 = (blob, mimeType) => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onloadend = () => {
      const dataUrlPrefix = `data:${mimeType};base64,`;
      const base64WithDataUrlPrefix = reader.result;
      const base64 = base64WithDataUrlPrefix.replace(dataUrlPrefix, '');
      resolve(base64);
    };
    reader.onerror = reject;
    reader.readAsDataURL(blob);
  });
};
```

```js
const obj = { hello: 'world' };
const mimeType = 'application/json';
const blob = new Blob([JSON.stringify(obj, null, 2)], { type: mimeType });

const base64 = await blob2base64(blob, mimeType);
console.log(base64);

// or

blob2base64(blob, mimeType).then((base64) => {
  console.log(base64);
});
```
