const validate = form => {
  let isValid = true;
  const data = new FormData(form);

  for (const [k, v] of data.entries()) {
    if (!v.trim().length) {
      const input = document.querySelector(`[name=${k}]`);

      input.classList.add('error');
      isValid = false;

      setTimeout(() => {
        isValid = true;
        input.classList.remove('error');
      }, 2000);
    }
    data.set(k, v.trim());
  }

  if (isValid) {
    return data;
  }

  return false;
};

const getParams = () => {
  const url = window.location.href.split('?');
  
  return "?" + url[1];
};

const pushState = (key, value) => {
  const location = window.location.search.substr(1);
  const paramsStr = location.split('&');

  const params = paramsStr.map(param => {
    return param.split('=');
  });
  const paramsObj = params.reduce((acc, val) => ({
    ...acc,
    [val[0]] : val[1]
  }), {});

  paramsObj[key] = value;

  const newParams = Object.keys(paramsObj).map(key => `${key}=${paramsObj[key]}`).join('&');

  history.pushState({param: 'Value'}, '', `?${newParams}`);
};
