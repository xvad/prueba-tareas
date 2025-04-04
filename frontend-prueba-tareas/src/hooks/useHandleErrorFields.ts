import { useEffect, useState } from 'react';

const useHandleErrorFields = () => {
    
    const fieldArrayErrors = (name: string, errors : any) => {
        if (errors && typeof errors === 'object') {
            const nameArray = name.split('.').map((part) => part.replace(/[^\w\s]/gi, '')); // Eliminar caracteres especiales
            const key = nameArray[0];
            const index = parseInt(nameArray[1]); // Convertir el índice a número
            const subKey = nameArray[2];
      
             if (
                errors[key] &&
                Array.isArray(errors[key]) &&
                errors[key][index] &&
                errors[key][index][subKey]
            ) {
                
                return errors[key][index][subKey];
            }
        }
        return undefined;
    };

    const getArrayPath = (name: string, errors : any) => {
        if (errors && typeof errors === 'object') {
            const nameArray = name.split('.').map((part) => part.replace(/[^\w\s]/gi, '')); // Eliminar caracteres especiales
            const key = nameArray[0];
            const index = parseInt(nameArray[1]); // Convertir el índice a número
            const subKey = nameArray[2];
 
             if (
                errors[key] &&
                Array.isArray(errors[key]) &&
                errors[key][index] &&
                errors[key][index][subKey]
            ) {
                
                return [key, index.toString(), subKey];
            }
        }
        return undefined;
    };

    const fieldErrorMessage = (name: string, errors : any, isArray = false) => {

        let _errors = errors;
       
        if (isArray) {
            _errors = fieldArrayErrors(name, errors);
        }
        console.log(_errors);
        if (_errors) {
        
            if (isArray) {
              
                return _errors;
            }
            if (_errors[name]) {
                return _errors[name][0];
            }
        }
        return '';
    };


    const fieldHasError = (name: string, errors : any, isArray = false) => {
        let _errors = errors;
        
        if (isArray) {
            _errors = fieldArrayErrors(name, errors);
        }
        if (_errors) {
            if (isArray) {
                return 'is-invalid';
            }
            if (_errors[name]) {
                return 'is-invalid';
            }
        }
        return '';
    };

    const onFocusRemove = (
        name: string,
        errors: any,
        setErrors: (val: any) => void,
        isArray = false
      ) => {
        const updatedErrors = { ...errors };
      
        if (isArray) {
          const path = getArrayPath(name, errors);
          if (path) {
            const [key, index, subKey] = path;
            if (updatedErrors[key] && updatedErrors[key][index]) {
              updatedErrors[key][index] = {
                ...updatedErrors[key][index],
                [subKey]: undefined,
              };
            }
          }
        } else {
          updatedErrors[name] = undefined;
        }
      
        setErrors(updatedErrors);
      };
      



    return {
        fieldErrorMessage,
        fieldHasError,
        onFocusRemove,
    };
};

export default useHandleErrorFields;
