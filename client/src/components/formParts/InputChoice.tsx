import { useState } from 'react';
import { useRecoilState } from 'recoil';
import { errorMessageState } from '../../states/atoms/errorMessageAtom';
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

  // エラーメッセージのstate
  const [errorMessage, setErrorMessage] = useRecoilState(errorMessageState);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const target = e.target;
    const newInput = target.value;

    // 文字入力後エラーメッセージを外す
    removeError(target);
    const removeErrorMessage = {...errorMessage};
    delete removeErrorMessage[`choice_${displayOrder}`];
    setErrorMessage(removeErrorMessage);

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
      {errorMessage[`choice_${displayOrder}`] ? (
        <div className={styles.error_area}>
          <span className={styles.error_text}>{errorMessage[`choice_${displayOrder}`]}</span>
        </div>
      ) : null}
    </>
  );
};
