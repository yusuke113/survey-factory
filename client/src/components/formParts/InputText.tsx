import React, { useContext } from 'react';
import { SetterOrUpdater } from 'recoil';
import { ErrorMessage } from '../../pages/questionnaires/create';
import styles from '../../styles/components/formParts/Form.module.scss';
import { removeError } from '../../utils/validation';

interface InputTextProps {
  title: string;
  id: string;
  name: string;
  placeholder: string;
  maxLength: number;
  validationName: string;
  inputText: string;
  setInputText: SetterOrUpdater<string>;
  inputTextLength: number
}

export const InputText: React.FC<InputTextProps> = ({
  title,
  id,
  name,
  placeholder,
  maxLength,
  validationName,
  inputText,
  setInputText,
  inputTextLength
}) => {
  // エラーメッセージ
  const error = useContext(ErrorMessage);

  const handleChange = (e: any) => {
    const target = e.target;
    // 文字入力後エラーを外す
    removeError(target);

    // 最大文字数に達していない場合のみ入力を反映
    if (target.value.length <= maxLength) {
      setInputText(target.value);
    }
  };

  return (
    <div className={styles.input_row}>
      <label htmlFor={id} className={styles.text_label}>
        {title}
        <span className={styles.text_count}>
          {inputTextLength}/{maxLength}
        </span>
      </label>
      <input
        type="text"
        id={id}
        className={`${styles.form_parts} ${styles.input_text} validate-text`}
        name={name}
        placeholder={placeholder}
        maxLength={maxLength}
        data-validation-name={validationName}
        value={inputText}
        onChange={handleChange}
      />
      {error['title'] ? (
        <div className={styles.error_area}>
          <span className={styles.error_text}>{error['title']}</span>
        </div>
      ) : null}
    </div>
  );
};
