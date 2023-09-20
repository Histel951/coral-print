import {ref, watch, watchEffect} from "vue";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";
import useForm from "@/composables/useForm";
import useInitData from "@/composables/useInitData";
import useFormSchema from "@/composables/useFormSchema";
import cloneDeep from 'lodash/cloneDeep';
import useFieldsExtra from "@/composables/useFieldsExtra";

const getPriorityRule = (rules) => {
    let priorityRules = [];

    rules.forEach(rule => {
        if (rule.priority) {
            priorityRules.push(rule);
        }
    });

    if (priorityRules.length) {
        return priorityRules.reduce((acc, curr) => acc.priority > curr.priority ? acc : curr);
    }

    return null;
};

const {fields, calculator_id} = useFormSchema();

const {disableField, disabledItems, disableItems, allCheckDisabledItems, dropDisabledItemsByField, disableAction, dropAction} = useFieldConditionsHelpers();

const {setExtraLabel, setExtraHideTypes, setExtraPredefinedValue} = useFieldsExtra();

export default (conditions = {}, fieldName) => {
    const {form} = useForm();
    const {getData, data} = useInitData();

  const readOnly = ref(false);
  const visible = ref(1);
  const hidden = ref(0);

    const changeFieldWithIdentValues = (fieldName, identValue) => {
        const data = getData(fieldName);

        if (data) {
            if (data.all_items) {
                data.data.some(item => {
                    if (item !== identValue) {
                        form[fieldName] = item.id;
                        return true;
                    }
                });

                return;
            }

            data.some(item => {
                if (item !== identValue) {
                    form[fieldName] = item.id;
                    return true;
                }
            });
        }
    };

    const disableFieldItem = (itemId, fieldData) => {
        if (fieldData) {
            fieldData.forEach(item => {
                item.disabled = item.id === itemId;
            });
        }
    };

    if (conditions.labelFormChange) {
        conditions.labelFormChange.forEach(rule => {
            const formFields = Object.keys(rule.values);
            watch(() => formFields.map(field => form[field]), () => {
                const changeFieldIndex = fields.value.findIndex(field => field.formField === fieldName);

                let check = false;
                let label = cloneDeep(fields.value[changeFieldIndex].label);
                Object.keys(rule.values).some(formField => {
                    Object.keys(rule.values[formField]).some(formValue => {
                        if (form[formField] == formValue) {
                            check = true;
                            label = rule.values[formField][formValue];
                        }

                        return check;
                    });

                    return check;
                });

                if (!check) {
                    setExtraLabel(rule.default, fields.value[changeFieldIndex].formField);
                    return;
                }

                setExtraLabel(label, fields.value[changeFieldIndex].formField);
            });
        });
    }

    if (conditions.countHideTypes) {
        conditions.countHideTypes.forEach(rule => {
            watch(() => Object.keys(rule.values).map(field => form[field]), () => {
                Object.keys(rule.values).forEach(field => {
                    const changeFieldIndex = fields.value.findIndex(changeField => field === changeField.formField);
                    setExtraHideTypes(rule.values[field] === form[field], fields.value[changeFieldIndex].formField);
                });
            });
        });
    }

    if (conditions.maxFieldsValues) {
        conditions.maxFieldsValues.forEach(rule => {
            let thisData = {};

            rule.data_keys.forEach(key => {
                thisData[key] = cloneDeep(getData(key));
            })

            watch(() => rule.data_keys.map(dataKey => form[dataKey]), () => {
                const refData = {};
                const activeValues = {};
                let sumValues = 0;
                const minMaxValues = {
                    min: {
                        fieldName: '',
                        value: 0
                    },
                    max: {
                        fieldName: '',
                        value: 0
                    }
                };

                rule.data_keys.forEach(key => {
                    refData[key] = getData(key);
                });

                Object.keys(thisData).forEach(fieldKey => {
                    const activeItem = thisData[fieldKey].find(item => item.id === form[fieldKey]);
                    if (activeItem) {
                        activeValues[fieldKey] = activeItem[rule.data_value_key];
                    }
                });

                if (!Object.keys(activeValues).length) {
                    return;
                }

                Object.keys(activeValues).forEach(field => {
                    sumValues += activeValues[field];
                });

                if (sumValues !== 0) {
                    Object.keys(activeValues).forEach(fieldKey => {
                        if (!minMaxValues.min.fieldName.length || activeValues[fieldKey] < minMaxValues.min.value) {
                            minMaxValues.min.fieldName = fieldKey;
                            minMaxValues.min.value = activeValues[fieldKey];
                        }
                    });

                    Object.keys(activeValues).forEach(fieldKey => {
                        if (!minMaxValues.max.fieldName.length || activeValues[fieldKey] > minMaxValues.max.value) {
                            minMaxValues.max.fieldName = fieldKey;
                            minMaxValues.max.value = activeValues[fieldKey];
                        }
                    });


                    data.value[minMaxValues.min.fieldName] = cloneDeep(thisData[minMaxValues.min.fieldName]);
                    data.value[minMaxValues.max.fieldName] = cloneDeep(thisData[minMaxValues.max.fieldName]);
                    refData[minMaxValues.min.fieldName] = getData(minMaxValues.min.fieldName);
                    refData[minMaxValues.max.fieldName] = getData(minMaxValues.max.fieldName);

                    Object.keys(refData[minMaxValues.min.fieldName]).forEach(index => {
                        const maxValue = refData[minMaxValues.min.fieldName][index][rule.data_value_key] + minMaxValues.max.value;

                        if (refData[minMaxValues.min.fieldName][index] && rule.max_value < maxValue) {

                            if (refData[minMaxValues.min.fieldName][index][rule.data_value_key]) {
                                delete refData[minMaxValues.min.fieldName][index];
                            }
                        }
                    });
                } else {
                    Object.keys(refData).forEach(field => {
                        refData[field] = cloneDeep(thisData[field]);
                    });
                }
            });
        });
    }

  if (conditions.max_size_disable) {
      conditions.max_size_disable.forEach(rule => {
          watchEffect(() => {

              let size;
              if (form.diameter) {
                  size = form.diameter;
              } else {
                  size = Math.max(form.width, form.height);
              }

              if (size > rule.value) {
                  disableItems(rule.field, rule.values, fieldName);
              } else {
                  if (disabledItems.value[rule.field]) {
                      delete disabledItems.value[rule.field];
                  }
              }
          });
      });
  }

  if (conditions.isUsePredefinedValues) {
      const changeFieldPredefinedValues = (value) => {
          Object.keys(fields.value).some(key => {
              if (fields.value[key].formField === fieldName) {
                  setExtraPredefinedValue(value, fieldName);
                  return true;
              }
          });
      };

      conditions.isUsePredefinedValues.forEach(rule => {
          watch(() => form[rule.field], () => {
              dropAction(fieldName);

              if (!rule.calculator) {
                  changeFieldPredefinedValues(rule.value.includes(form[rule.field]));
                  return;
              }

              let check;

              if (Array.isArray(rule.calculator)) {
                  check = rule.calculator.includes(calculator_id.value);
              } else {
                  check = calculator_id === rule.calculator;
              }

              if (check && rule.no_action) {
                  disableAction(fieldName);
              }

              if (check && rule.value) {
                  check = rule.value.includes(form[rule.field]);
              }

              changeFieldPredefinedValues(check);
          });
      });
  }

  if (conditions.readonlyMany) {
      const activeCondition = {};

      conditions.readonlyMany.forEach(rule => {
          watch(() => [
              form[fieldName],
              ...Object.keys(rule.values).map(field => form[field])
          ], () => {

              let checkActive = true;
              if (activeCondition[fieldName]) {
                  Object.keys(activeCondition[fieldName]).some(field => {
                      if (typeof activeCondition[fieldName][field] !== 'undefined'
                          && form[field] !== activeCondition[fieldName][field]) {
                          activeCondition[fieldName] = {};
                          checkActive = false;

                          return true;
                      }
                  });
              }

              if (checkActive && activeCondition[fieldName] && Object.keys(activeCondition[fieldName]).length) {
                  return;
              }

              let checks = [];

              Object.keys(rule.values).forEach(field => {
                  checks.push(form[field] === rule.values[field]);
              });

              const check = !checks.includes(false);

              if (check) {
                  activeCondition[fieldName] = {};

                  Object.keys(rule.values).forEach(field => {
                      activeCondition[fieldName][field] = form[field];
                  });

                  if (rule.default_value) {
                      form[fieldName] = rule.default_value;
                  }
              }

              readOnly.value = check;
          });
      });
  }

  if (conditions.selectedMany) {
      conditions.selectedMany.forEach(rule => {
          watch(() => Object.keys(rule.values).map(field => form[field]), () => {
              let checks = [];
              Object.keys(rule.values).some(field => {
                  checks.push(form[field] === rule.values[field]);
              });

              const allCheck = !checks.includes(false);

              if (allCheck) {
                  form[fieldName] = Number(rule.value);
              }
          });
      });
  }

  if (conditions.readonly) {
    conditions.readonly.forEach((rule) => {
      watch(() => [form[rule.field], readOnly.value], () => {
          if (conditions.readonly.length > 1) {

              const priorityCondition = getPriorityRule(conditions.readonly);

              if (priorityCondition) {

                  if (Number(form[priorityCondition.field])) {
                      if (Array.isArray(priorityCondition.value)) {
                          readOnly.value = priorityCondition.value.includes(form[priorityCondition.field]);
                      } else {
                          readOnly.value = form[priorityCondition.field] == priorityCondition.value;
                      }
                  } else if (priorityCondition.field !== rule.field) {
                      if (Array.isArray(rule.value)) {
                          readOnly.value = rule.value.includes(form[rule.field]);
                      } else {
                          readOnly.value = form[priorityCondition.field] == rule.value;
                      }
                  }
              } else {
                  const trueCondition = conditions.readonly.filter(rule => {
                      if (Array.isArray(rule.value)) {
                          return rule.value.includes(form[rule.field]);
                      }

                      return rule.value == form[rule.field];
                  });

                  readOnly.value = trueCondition.length > 0;
              }
          } else {
              if (Array.isArray(rule.value)) {
                  readOnly.value = rule.value.includes(form[rule.field]);
              } else {
                  readOnly.value = form[rule.field] == rule.value;
              }
          }
      });
    })
  }

  if (conditions.readonlyOr) {
      conditions.readonlyOr.forEach(rule => {


          watch(() => Object.keys(rule.fields_values).map(field => form[field]), () => {
              let isDisabledValue = false;

              Object.keys(rule.fields_values).some(field => {
                  if (form[field] === rule.fields_values[field]) {
                      isDisabledValue = true;
                  }

                  return isDisabledValue;
              });

              Object.keys(rule.readonly_fields).forEach(field => {
                  if (isDisabledValue) {
                      disableField(field, `${fieldName}_${field}`, true);
                      form[field] = rule.readonly_fields[field];
                  } else {
                      disableField(field, `${fieldName}_${field}`, false);
                  }
              });
          })
      });
  }

    if (conditions.readonlyAnd) {
        conditions.readonlyAnd.forEach(rule => {
            watchEffect(() => {
                const checks = Object.keys(rule.field_values).map(key => form[key] === rule.field_values[key]);
                const allCheck = Number(!checks.includes(false));

                if (allCheck) {
                    form[rule.change_field] = rule.value;
                }

                readOnly.value = allCheck;
            });
        });
    }

    if (conditions.disabledIfValue) {
        conditions.disabledIfValue.forEach(rule => {
            watch(form, () => {
                const fieldsData = {};

                [rule.dependence_field, fieldName].forEach(dependenceFieldName => {
                    const data = getData(dependenceFieldName);

                    if (data.all_items) {
                        fieldsData[dependenceFieldName] = data.data;
                    } else {
                        fieldsData[dependenceFieldName] = data;
                    }

                    fieldsData[dependenceFieldName].activeEl = fieldsData[dependenceFieldName].find(el => el.id === form[dependenceFieldName]);
                });

                if (fieldsData) {
                    [rule.dependence_field, fieldName].forEach(field => {
                        fieldsData[field].forEach(el => {
                            el.disabled = false;
                        });
                    })
                }

                if (form[fieldName] === rule.if_value) {
                    disableFieldItem(rule.dependence_value, fieldsData[rule.dependence_field]);
                }

                if (form[fieldName] === rule.dependence_value) {
                    disableFieldItem(rule.if_value, fieldsData[rule.dependence_field]);
                }

                if (form[rule.dependence_field] === rule.if_value) {
                    disableFieldItem(rule.dependence_value, fieldsData[fieldName]);
                }

                if (form[rule.dependence_field] === rule.dependence_value) {
                    disableFieldItem(rule.if_value, fieldsData[fieldName]);
                }
            });
        });
    }

    if (conditions.blockingIdenticalValues) {
        conditions.blockingIdenticalValues.forEach(rule => {
            watch(() => ({...form}), (newForm, oldForm) => {
                let fieldsWithIdentValues = [];
                const fieldsValues = {};
                const fieldsData = {};

                rule.fields.forEach(dependenceFieldName => {
                    fieldsValues[dependenceFieldName] = newForm[dependenceFieldName];
                    dropDisabledItemsByField(dependenceFieldName);
                });

                rule.fields.forEach(dependenceFieldName => {
                    const data = getData(dependenceFieldName);

                    if (data.all_items) {
                        fieldsData[dependenceFieldName] = data.data;
                    } else {
                        fieldsData[dependenceFieldName] = data;
                    }

                    fieldsData[dependenceFieldName].activeEl = fieldsData[dependenceFieldName].find(el => el.id === form[dependenceFieldName]);
                });

                rule.fields.forEach(dependenceFieldName => {
                    rule.fields.forEach(nextDependenceFieldName => {
                        if (dependenceFieldName !== nextDependenceFieldName) {
                            fieldsData[nextDependenceFieldName].forEach(el => {
                                el.disabled = fieldsData[dependenceFieldName].activeEl && fieldsData[dependenceFieldName].activeEl.id === el.id;
                            });
                        }
                    });
                });

                // получение всех полей с одинаковыми значениями
                Object.keys(fieldsValues).forEach(mainKey => {
                    const identFields = Object.keys(fieldsValues).filter(key => fieldsValues[key] === fieldsValues[mainKey]);

                    if (identFields.length > 1) {
                        fieldsWithIdentValues = fieldsWithIdentValues.concat(identFields);
                    }
                });

                // помещать в цикл уже полученные поля с одинакомыми значениями
                fieldsWithIdentValues = Array.from(new Set(fieldsWithIdentValues));
                if (fieldsWithIdentValues.length > 1) {
                    fieldsWithIdentValues.forEach(identFieldName => {
                        if (oldForm[identFieldName] !== newForm[identFieldName]) {
                            changeFieldWithIdentValues(identFieldName, fieldsValues[identFieldName]);
                            disableItems(identFieldName, [fieldsValues[identFieldName]]);
                        }
                    });
                }
            });
        });
    }

    if (conditions.readonlyIn) {
        conditions.readonlyIn.forEach(rule => {
            watch(() => form[rule.field], () => {
                if (Number(rule.values.includes(form[rule.field]))) {
                    disableField(rule.change_field, `${rule.change_field}_${rule.field}`, true);
                    form[rule.change_field] = rule.value;
                } else {
                    disableField(rule.change_field, `${rule.change_field}_${rule.field}`, false);
                }
            });
        });
    }

    if (conditions.readonlyItemsIn) {

        if (typeof conditions.readonlyItemsIn === 'object') {
            conditions.readonlyItemsIn = Object.values(conditions.readonlyItemsIn);
        }

        const activeCondition = {};
        conditions.readonlyItemsIn.forEach(rule => {
            allCheckDisabledItems.value[rule.block] = {};
            watch(() => [form[rule.change_field], form[rule.field]], ([changeFieldValue, ruleFieldValue]) => {

                if (disabledItems.value[rule.change_field] && activeCondition[rule.field] === ruleFieldValue) {
                    return;
                }

                activeCondition[rule.field] = ruleFieldValue;

                const getReadOnlyItems = (disabledItems) => {

                    if (!conditions.unReadOnlyItemsIn) {
                        return disabledItems;
                    }

                    conditions.unReadOnlyItemsIn.forEach(unReadOnly => {
                        if (form[unReadOnly.field] === unReadOnly.value) {
                            unReadOnly.values.map(item => {
                                const itemIndex = disabledItems.findIndex(disableCondItem => disableCondItem === item);

                                delete disabledItems[itemIndex];
                            });
                        } else {
                            unReadOnly.values.map(item => {
                                if (!disabledItems.includes(item)) {
                                    disabledItems.push(item);
                                }
                            });
                        }
                    });

                    return disabledItems;
                };

                const readOnlyItems = getReadOnlyItems(rule.disabled_items);

                if (rule.values.includes(form[rule.field])) {

                    disableItems(rule.change_field, readOnlyItems, rule.field);
                    allCheckDisabledItems.value[rule.block][rule.field] = true;

                    if (rule.disabled_items.includes(changeFieldValue) && rule.value) {
                        form[rule.change_field] = rule.value;
                    }
                } else if (!rule.values.includes(form[rule.field])) {
                    allCheckDisabledItems.value[rule.block][rule.field] = false;
                    // disableItems(rule.change_field, readOnlyItems, rule.field);
                }

                const values = Object.keys(allCheckDisabledItems.value[rule.block]).map(key => allCheckDisabledItems.value[rule.block][key]);
                if (!values.includes(true)) {
                    disabledItems.value = {};
                }
            });
        });
    }

  if (conditions.visible) {
    conditions.visible.forEach((rule) => {
      watchEffect(() => {
        visible.value = form[rule.field] == rule.value;

        if (fieldName === 'diameter') {
            form.is_diameter = Number(visible.value);
        }
      })
    })
  }
  if (conditions.hidden) {
    conditions.hidden.forEach((rule) => {
      watchEffect(() => {
        hidden.value = form[rule.field] == rule.value;
      })
    })
  }
  if (conditions.checked) {
    conditions.checked.forEach((rule) => {
      watchEffect(() => {
        if (form[rule.field] === rule.value) {
          form[fieldName] = 1;
        }
      })
    })
  }

    if (conditions.unchecked) {
        conditions.unchecked.forEach((rule) => {
            watchEffect(() => {
                if (Array.isArray(rule.value) && rule.value.includes(form[rule.field])) {
                    form[fieldName] = 0;
                }

                if (form[rule.field] === rule.value) {
                    form[fieldName] = 0;
                }
            })
        })
    }

    if (conditions.selectedAnd) {
        conditions.selectedAnd.forEach(rule => {
            watch(() => Object.keys(rule.field_values).map(key => form[key]), () => {

                const checks = Object.keys(rule.field_values).map(key => {
                    if (typeof rule.field_values[key][Symbol.iterator] === 'function') {
                        return rule.field_values[key].includes(form[key]);
                    }

                    return form[key] === rule.field_values[key];
                });

                const allCheck = !checks.includes(false);

                if (allCheck) {
                    form[rule.change_field] = rule.value;
                }
            })
        });
    }

  if (conditions.selected) {
    conditions.selected.forEach((rule) => {
      watch(form, () => {

          if (rule.change_field) {

              if (form[rule.field] === rule.value) {
                  form[rule.change_field] = rule.selected_value;
                  readOnly.value = true;
              } else {
                  readOnly.value = false;
              }

              return;
          }

          const priorityCondition = getPriorityRule(conditions.selected);

          if (priorityCondition) {

              if (Number(form[priorityCondition.field])) {
                  if (form[priorityCondition.field] === priorityCondition.value) {
                      form[fieldName] = priorityCondition.selected_value;
                      readOnly.value = true;
                  } else {
                      readOnly.value = false;
                  }

              } else if (priorityCondition.field !== rule.field) {
                  if (form[rule.field] === rule.value) {
                      form[fieldName] = rule.selected_value;
                      readOnly.value = true;
                  } else {
                      readOnly.value = false;
                  }

              }

              return;
          }

          if (form[rule.field] === rule.value) {
              form[fieldName] = rule.selected_value
              readOnly.value = true;
          } else {
              readOnly.value = false;
          }
      })
    })
  }


  return {
    readOnly,
    visible,
    hidden
  };
};
