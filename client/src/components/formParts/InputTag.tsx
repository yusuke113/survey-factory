import { GetServerSideProps, NextPage } from 'next';
import React, { useState } from 'react';
import styles from '../../styles/components/formParts/Form.module.scss';
import { TagUseCase } from '../../usecase/tagUseCase';

interface InputTagProps {
  title: string;
  id: string;
  name: string;
  placeholder: string;
  maxLength: number;
}

type TagList = {
  id: number;
  name: string;
};

const tagUseCase = new TagUseCase();

export const InputTag: React.FC<InputTagProps> = ({ title, id, name, placeholder, maxLength }) => {
  // タグ名のテキストフィールド
  const [tagInput, setTagInput] = useState('');
  // タグ名のテキストフィールドの文字数
  const [tagInputCount, setTagInputCount] = useState(0);
  // 追加されたタグのリスト
  const [tagList, setTagList] = useState<TagList[]>([]);

  // テキスト入力時のイベント
  const handleTagInputChange = (e: any) => {
    // 最大文字数の場合入力を拒否
    if (e.target.value.length > maxLength) {
      return;
    }

    setTagInput(e.target.value);
    setTagInputCount(e.target.value.length);
  };

  // エンターキー押下時タグを登録
  const handleTagSubmit = async (e: any) => {
    e.preventDefault();

    // リストが既に3つ以上の場合は登録しない
    if (tagList.length >= 3) {
      return;
    }

    const { data } = await tagUseCase.postTag(tagInput);
    const newTagList: TagList[] = [...tagList, data];

    setTagInput('');

    setTagList(newTagList);
  };

  const removeTag = (id: number) => {
    setTagList((tagList) => {
      return tagList.filter(tag => tag.id !== id);
    });
  };

  const testButton = () => {
    console.log(tagList);
  };

  return (
    <div className={styles.input_row}>
      <form onSubmit={handleTagSubmit}>
        <label htmlFor={id} className={styles.text_label}>
          {title}
          <span className={styles.text_count}>
            {tagInputCount}/{maxLength}
          </span>
        </label>
        <input
          type="text"
          id={id}
          className={`${styles.form_parts} ${styles.input} ${styles['-short']}`}
          name={name}
          placeholder={placeholder}
          maxLength={maxLength}
          value={tagInput}
          disabled={tagList.length >= 3}
          onChange={handleTagInputChange}
        />
        <div className={styles.tags}>
          {tagList.map((tag, key) => (
            <span className={styles.tag} id={`tag_${tag.id}`} key={key}>
              <span># {tag.name}</span>
              <a href="#" className={styles.tag_remove} title={`${tag.name}タグを削除`} onClick={() => removeTag(tag.id)}></a>
            </span>
          ))}
        </div>
      </form>
      <button onClick={testButton}>確認ボタン</button>
    </div>
  );
};
