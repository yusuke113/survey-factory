import { useRecoilValue } from 'recoil';
import { addChoiceListState } from '../../states/atoms/addChoiceListAtom';
import styles from '../../styles/components/formParts/Form.module.scss';
import { InputChoice } from './InputChoice';

interface InputChoiceAreaProps {
  title: string;
}

export const InputChoiceArea: React.FC<InputChoiceAreaProps> = ({ title }) => {
  // 選択肢リストのstate
  const addChoiceList = useRecoilValue(addChoiceListState);

  return (
    <div className={styles.input_row}>
      <div className={styles.choice_create}>
        <label htmlFor="#" className={styles.text_label}>
          {title}
        </label>
        {addChoiceList.map((inputChoice, key) => (
          <InputChoice
            index={key}
            displayOrder={inputChoice.displayOrder}
            maxLength={30}
            validationName="選択肢"
            key={key}
          />
        ))}
      </div>
    </div>
  );
};
