import { faFileImage } from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import styles from '../../styles/components/formParts/Form.module.scss';

interface InputImageProps {
  title: string;
  id: string;
  name: string;
}

export const InputImage: React.FC<InputImageProps> = ({ title, id, name }) => {
  return (
    <div className={styles.input_row}>
      <label htmlFor={id} className={styles.image_label}>
        <FontAwesomeIcon icon={faFileImage} />
        {title}
      </label>
      <input
        type="file"
        id={id}
        className={`${styles.form_parts} ${styles.input_image}`}
        name={name}
      />
    </div>
  );
};
