import { GetServerSideProps, NextPage } from 'next';
import React, { useState } from 'react';
import styles from '../../styles/components/formParts/Form.module.scss';

interface InputTextProps {
  title: string;
  id: string;
  name: string;
  placeholder: string;
  maxLength: number;
}

export const InputText: React.FC<InputTextProps> = ({ title, id, name, placeholder, maxLength }) => {

  // タグ名のテキストフィールド
  const [textInput, setTextInput] = useState('');
  // タグ名のテキストフィールドの文字数
  const [textInputCount, setTextInputCount] = useState(0);

  const handleTagInputChange = (e: any) => {
    // 最大文字数の場合入力を拒否
    if (e.target.value.length > maxLength) {
      return false;
    }

    setTextInput(e.target.value);
    setTextInputCount(e.target.value.length);
  };

  return (
    <div className={styles.input_row}>
      <label htmlFor={id} className={styles.text_label}>
        {title}
        <span className={styles.text_count}>{textInputCount}/{maxLength}</span>
      </label>
      <input
        type="text"
        id={id}
        className={`${styles.form_parts} ${styles.input}`}
        name={name}
        placeholder={placeholder}
        maxLength={maxLength}
        value={textInput}
        onChange={handleTagInputChange}
      />
    </div>
  );
};
