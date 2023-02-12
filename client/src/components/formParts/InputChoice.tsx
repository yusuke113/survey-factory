import { useState } from 'react';
import styles from '../../styles/components/formParts/Form.module.scss';
import { removeError } from '../../utils/validation';

interface InputChoiceProps {
  index: number;
  displayOrder: number;
  maxLength: number;
  validationName: string;
}

export const InputChoice: React.FC<InputChoiceProps> = ({
  index,
  displayOrder,
  maxLength,
  validationName,
}) => {
  // 選択肢のテキストフィールドと文字数のstate
  const [inputChoice, setInputChoice] = useState('');

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const target = e.target;
    const newInput = target.value;

    // 文字入力後エラーを外す
    removeError(target);

    // 最大文字数に達していない場合のみ入力を反映
    if (newInput.length <= maxLength) {
      setInputChoice(target.value);
    }
  };

  return (
    <>
      <label htmlFor={`choice_${displayOrder}`} className={styles.text_label}></label>
      <input
        type="text"
        id={`choice_${displayOrder}`}
        className={`${styles.form_parts} ${styles.input_text} validate-text`}
        name={`choice_${displayOrder}`}
        placeholder={`${displayOrder}つ目の選択肢`}
        maxLength={maxLength}
        value={inputChoice}
        data-validation-name={validationName}
        onChange={handleChange}
      />
    </>
  );
};
