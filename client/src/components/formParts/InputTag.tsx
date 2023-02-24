import { useEffect } from 'react';
import { useRecoilState, useRecoilValue } from 'recoil';
import { Tag } from '../../domain/models/tag';
import { addTagListState } from '../../states/atoms/addTagListAtom';
import { inputTagState } from '../../states/atoms/inputTagAtom';
import { addTagListLengthState } from '../../states/selectors/addTagListLengthSelector';
import { inputTagLengthState } from '../../states/selectors/inputTagLengthSelector';
import styles from '../../styles/components/formParts/Form.module.scss';
import { TagUseCase } from '../../useCase/tagUseCase';
import { detectDuplicates } from '../../utils/arrayUtils';

interface InputTagProps {
  title: string;
  id: string;
  name: string;
  placeholder: string;
  maxLength: number;
}

const tagUseCase = new TagUseCase();

export const InputTag: React.FC<InputTagProps> = ({ title, id, name, placeholder, maxLength }) => {
  // タグ名のテキストフィールドと文字数のstate
  const [inputTag, setInputTag] = useRecoilState(inputTagState);
  const inputTagLength = useRecoilValue(inputTagLengthState);

  // 追加されたタグリストとそのリストに含まれるタグの個数
  const [addTagList, setAddTagList] = useRecoilState(addTagListState);
  const addTagListLength = useRecoilValue(addTagListLengthState);

  // 初期化
  useEffect(() => {
    if (addTagList.length === 0) {
      setInputTag('');
    }
  }, [addTagList]);

  // テキスト入力時のイベント
  const handleInputChange = (e: any) => {
    // 最大文字数に達していない場合のみ入力を反映
    if (e.target.value.length <= maxLength) {
      setInputTag(e.target.value);
    }
  };

  // エンターキー押下時タグを登録
  const handleSubmit = async (e: any) => {
    e.preventDefault();

    /*
     * 1. リストが既に3つ以上の場合は登録しない
     * 2. タグ名入力欄が空の場合は登録しない
     */
    if (addTagListLength >= 3 || inputTag === '') {
      return;
    }

    const { data } = await tagUseCase.postTag(inputTag);

    let newTagList: Tag[] = [...addTagList, data];

    if (detectDuplicates(newTagList)) {
      newTagList = [...addTagList];
      setInputTag('');
      return;
    }

    setInputTag('');
    setAddTagList(newTagList);
  };

  const removeTag = (id: number) => {
    setAddTagList((tagList) => {
      return tagList.filter((tag) => tag.id !== id);
    });
  };

  return (
    <div className={styles.input_row}>
      <form className={styles.tag_form} onSubmit={handleSubmit}>
        <label htmlFor={id} className={styles.text_label}>
          {title}
          <span className={styles.text_count}>
            {inputTagLength}/{maxLength}
          </span>
        </label>
        <input
          type="text"
          id={id}
          className={`${styles.form_parts} ${styles.input_text}`}
          name={name}
          placeholder={addTagListLength >= 3 ? '3つ設定済み' : placeholder}
          maxLength={maxLength}
          value={inputTag}
          disabled={addTagListLength >= 3}
          onChange={handleInputChange}
        />
      </form>
      <div className={styles.tags}>
        {addTagList.map((tag, key) => (
          <span className={styles.tag} id={`tag_${tag.id}`} key={key}>
            <span># {tag.name}</span>
            <a
              href="#"
              className={styles.tag_remove}
              title={`${tag.name}タグを削除`}
              onClick={() => removeTag(tag.id)}
            ></a>
          </span>
        ))}
      </div>
    </div>
  );
};