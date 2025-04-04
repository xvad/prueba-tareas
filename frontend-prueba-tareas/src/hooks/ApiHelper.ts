export const ResponseStatus = {
    UNKNOWN: 'unknown',
    ERROR: 'error',
    SUCCESS: 'success',
    WARNING: 'warning',
    INFO: 'info',
    FIELDS_VALIDATION: 'fields_validation'
};

export const getFormData = (object: any) => {
    return objectToFormData(object);
};

export const objectToFormData = (data: any, formData: FormData = new FormData()) => {
    let indexFiles = 0;
    Object.keys(data).forEach((key) => {
        if (data[key] === undefined) {
            return;
        }
        if (data[key] instanceof File) {
            formData.append(key, data[key]);
        } else if (Array.isArray(data[key]) || data[key] instanceof Object) {
            if (Array.isArray(data[key])) {
                data[key].forEach((item: any) => {
                    if (item instanceof Object) {
                        Object.keys(item).forEach((_key: any) => {
                            formData.append(`${key}[${indexFiles}]${_key}`, item[_key]);
                        });
                        indexFiles++;
                        // objectToFormData(item, formData.);
                    } else if (item instanceof File) {
                        formData.append(key + '[]', item);
                    } else {
                        formData.append(key, JSON.stringify(item));
                    }
                });
            } else {
                Object.keys(data[key]).forEach((subKey) => {
                    if (data[key][subKey] instanceof File) {
                        formData.append(`${key}[${subKey}]`, data[key][subKey]);
                    } else {
                        formData.append(`${key}[${subKey}]`, JSON.stringify(data[key][subKey]));
                    }
                });
            }
        } else {
            formData.append(key, data[key]);
        }
    });
    return formData;
};
